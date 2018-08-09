<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, StaplerableInterface
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        EloquentTrait,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'bio',
        'nickname',
        'email',
        'password',
        'classroom_id',
        'masterteacher',
        'email_deleted',
        'school_id',
        'role_id'
    ];

    /**
     * The attributes that are appended to this object when it's returned
     *
     * @var array
     */
    protected $appends = [
        'display_name',
        'avatar_url'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that are returned as dates
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * User constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = array()) {

        $this->hasAttachedFile('avatar', [
            'styles' => [
                'medium' => '350x350',
                'thumb' => '100x100'
            ],
            'url' => '/avatars/:attachment/:id_partition/:style/:filename',
            'default_url' => '/:attachment/:style/missing.jpg'
        ]);

        parent::__construct($attributes);
    }

    /**
     * A user's display name includes their nickname in quotes if they have one
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->nickname ?: $this->name;
    }

    /**
     * Default's the user's avatar if they don't have one
     *
     * @return string
     */
    public function getAvatarUrlAttribute($value)
    {
        return $this->avatar ? $this->avatar->url() : '/avatars/original/missing.jpg';
    }

    /**
     * A user has many messages that they have authored
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function authoredMessages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * A user has many comments that they have authored
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function authoredComments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * A user has many videos that they have authored
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function authoredVideos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * A user has many activities that they have authored
     *
     * @return Illuminate\Eloquent\Relations\HasMany
     */
    public function authoredActivities()
    {
        return $this->hasMany(Activity::class, 'author_id');
    }

    /**
     * A user has many messages that they are participating in
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphOneOrMany
     */
    public function messages()
    {
        return $this->morphedByMany(Message::class, 'userable');
    }

    /**
     * A user has many videos that they are participating in
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphOneOrMany
     */
    public function videos()
    {
        return $this->morphedByMany(Video::class, 'userable');
    }

    /**
     * A user belongs to just one role i.e. parent, teacher, master teacher
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * A user belongs to a classroom i.e. they're a parent that has a child in a class, or they're
     * a teacher that teaches in a class
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * A user can belong to many schools
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schools()
    {
        return $this->belongsToMany(School::class);
    }

    /**
     * Scope query to just users of a certain role type
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfRoleType($query, $type)
    {
        $type = is_string($type) ? [$type] : $type;

        return $query->join('roles', 'roles.id', '=', 'users.role_id')
            ->whereIn('roles.machine_name', $type)
            ->select('users.*');
    }

    /**
     * Scope query to just users in a certain classroom
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $classroom
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeInClassroom($query, $classroom)
    {
        return $query->join('classrooms', 'classrooms.id', '=', 'users.classroom_id')
            ->where('classrooms.name', '=', $classroom)
            ->select('users.*');
    }

    /**
     * Scope query to just users in a certain school
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param array $schools
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeInSchools($query, $schools)
    {
        return $query->join('school_user', 'school_user.user_id', '=', 'users.id')
            ->where('users.id','<>',Auth::id())
            ->whereIn('school_user.school_id', $schools->lists('id')->toArray())
            ->select('users.*')
            ->groupBy('users.id');

    }

    /**
     * Scope query to just include users that match a name or nickname
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function($query) use ($search) {
            $query->where('users.name', 'LIKE', "%$search%")
                ->orWhere('users.nickname', 'LIKE', "%$search%");
        });
    }

    /**
     * Convenience method for checking if the user is a certain role
     *
     * @param string $role
     * @return boolean
     */
    public function is($role)
    {
        return $this->role->machine_name == $role;
    }

    /**
     * Checks if the user is one of a selection of roles
     *
     * @param array $roles
     * @return boolean
     */
    public function isEither($roles)
    {
        return in_array($this->role->machine_name, $roles);
    }

    /**
     * Checks if the user should be able to see a page based on the subdomain
     * and its available features.
     *
     * @param string $feature
     * @return bool
     */
    public function canSee($feature)
    {
        $subdomain = app('router')->current()->getParameter('domain');

        $role_machine = $this->role->machine_name;

        // Get a list of features that are enabled for this domain
        $config = config("pages.subdomains.{$role_machine}.features", []);

        // If the feature that's being requested isn't enabled then issue a 404
        return in_array($feature, $config);
    }
}
