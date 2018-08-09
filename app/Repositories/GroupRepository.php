<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use App\User;
use App\School;
use Auth;

class GroupRepository
{
    /**
     * A list of possible groups
     * @var array $groups
     */
    protected $groups = [
        'parentsInSchool' => 'All parents in your school',
        'teachersInSchool' => 'All teachers in your school',
        'masterTeachersInSchool' => 'All coaches in your school',
        'masterTeacherAssignedTo' => 'The coach you are assigned to',
        'teachersForChild' => 'All teachers for your child',
        'parentsInClass' => 'All parents in your childs\'s class',
        'teachersAssignedTo' => 'All teachers you are assigned to',
        'schoolLeadersInSchool' => 'All school leaders in your school',
        'allMasterTeachers' => 'All coaches',
        'allSchoolLeaders' => 'All school leaders',
        'allParents' => 'All parents',
        'allTeachers' => 'All teachers',
        'allAdmins' => 'All admins',
        'parentsInSingleSchool' => 'All parents at %s',
        'teachersInSingleSchool' => 'All teachers at %s',
        'masterTeachersInSingleSchool' => 'All coaches at %s',
        'schoolLeadersInSingleSchool' => 'All school leaders at %s',
    ];

    /**
     * Determines which groups a particular role class can see
     * @var array $permissions
     */
    protected $permissions = [
        'parent' => [
            'parentsInClass',
            'teachersForChild'
        ],
        'teacher' => [
            'parentsInClass',
            'teachersInSchool',
            'masterTeacherAssignedTo'
        ],
        'coach' => [
            'teachersAssignedTo',
            'teachersInSchool',
            'masterTeachersInSchool',
            'parentsInSchool',
            'schoolLeadersInSchool',
            'allMasterTeachers'
        ],
        'school_leader' => [
            'masterTeachersInSchool',
            'teachersInSchool',
            'parentsInSchool',
            'allSchoolLeaders'
        ],
        'project_admin' => [
            'allParents',
            'allTeachers',
            'allMasterTeachers',
            'allSchoolLeaders',
            'allAdmins',
            'parentsInSingleSchool',
            'teachersInSingleSchool',
            'masterTeachersInSingleSchool',
            'schoolLeadersInSingleSchool'
        ]
    ];

    /**
     * Converts a collection of participants into an array of user IDs
     *
     * @param Illuminate\Support\Collection $participants
     * @return array
     */
    public function convertParticipantsToIds(Collection $participants)
    {
        // Format the collection of participants into user ids
        return $participants->map(function($participant)
        {
            // If the participant is a string that means that it's most likely a group that needs
            // converting into a set of IDs
            if (!(int) $participant) {
                return $this->getGroupUsers($participant, Auth::user())
                    ->lists('id')
                    ->toArray();
            }

            return $participant;
        })->flatten()
        ->unique()
        ->toArray();
    }

    /**
     * Returns a list of groups that a user can see
     *
     * @param App\User $user
     * @return array
     */
    public function getUserGroups(User $user)
    {
        // Get the user's role
        $role = $user->role->machine_name;

        // Super admins have the same permissions as project admins with regards
        // to groups
        if ($role == 'super_admin') {
            $role = 'project_admin';
        }

        // Get the list of groups that this user has access to
        return $this->permissions[$role];
    }

    /**
     * Returns a pretty list of groups that a user can see
     *
     * @param App\User $user
     * @return array
     */
    public function getUserGroupsPretty(User $user)
    {
        $groups = [];
        $permissions = $this->getUserGroups($user);
        $schools = School::all();

        foreach ($permissions as $permission) {

            // Get the pretty name for this group
            $group = $this->groups[$permission];

            // If the name has a %s it means we need to loop through all of the schools
            if (strpos($group, '%s') !== false) {
                foreach ($schools as $school) {
                    // TODO: make this sprintf work
                    $groups[$permission . ',' . $school->name] = sprintf($group, $school->name);
                }
            } else {
                $groups[$permission] = $group;
            }
        }

        return $groups;
    }

    /**
     * Get all group users for a particular user
     *
     * @param string $group
     */
    public function getGroupUsers($group, User $user)
    {
        // If the group has a comma in it, it means that the school is being included as well
        if (strpos($group, ',') !== false) {
            $group = explode(',', $group);
            $function = $group[0];
            $school = School::where('name', $group[1])->first();
            return call_user_func_array([$this, $function], [$school]);
        }

        $users = call_user_func_array([$this, $group], [$user]);

        return $users ?: new Collection;
    }

    public function parentsInClass(User $user)
    {
        return User::ofRoleType('parent')
            ->inClassroom($user->classroom->name)
            ->select('users.*')
            ->get();
    }

    public function parentsInSchool(User $user)
    {
        return User::ofRoleType('parent')
            ->inSchools($user->schools)
            ->select('users.*')
            ->get();
    }

    public function teachersInSchool(User $user)
    {
        return User::ofRoleType('teacher')
            ->inSchools($user->schools)
            ->select('users.*')
            ->get();
    }

    public function masterTeachersInSchool(User $user)
    {
        return User::ofRoleType('coach')
            ->inSchools($user->schools)
            ->select('users.*')
            ->get();
    }

    public function masterTeacherAssignedTo(User $user)
    {
        return User::where('id',$user->masterteacher)->get();
    }

    public function teachersForChild(User $user)
    {
        return User::ofRoleType('teacher')
            ->inClassroom($user->classroom->name)
            ->select('users.*')
            ->get();
    }

    public function teachersAssignedTo(User $user)
    {
        // TODO
    }

    public function schoolLeadersInSchool(User $user)
    {
        return User::ofRoleType('school_leader')
            ->inSchools($user->schools)
            ->select('users.*')
            ->get();
    }

    public function allMasterTeachers()
    {
        return User::ofRoleType('coach')
            ->select('users.*')
            ->get();
    }

    public function allSchoolLeaders()
    {
        return User::ofRoleType('school_leader')
            ->select('users.*')
            ->get();
    }

    public function allParents()
    {
        return User::ofRoleType('parent')
            ->select('users.*')
            ->get();
    }

    public function allTeachers()
    {
        return User::ofRoleType('teacher')
            ->select('users.*')
            ->get();
    }

    public function allAdmins()
    {
        return User::ofRoleType(['project_admin', 'super_admin'])
            ->select('users.*')
            ->get();
    }

    public function parentsInSingleSchool(School $school)
    {
        return User::ofRoleType('parent')
            ->inSchools(collect([$school]))
            ->select('users.*')
            ->get();
    }

    public function teachersInSingleSchool(School $school)
    {
        return User::ofRoleType('teacher')
            ->inSchools(collect([$school]))
            ->select('users.*')
            ->get();
    }

    public function masterTeachersInSingleSchool(School $school)
    {
        return User::ofRoleType('coach')
            ->inSchools(collect([$school]))
            ->select('users.*')
            ->get();
    }

    public function schoolLeadersInSingleSchool(School $school)
    {
        return User::ofRoleType('school_leader')
            ->inSchools(collect([$school]))
            ->select('users.*')
            ->get();
    }
}
