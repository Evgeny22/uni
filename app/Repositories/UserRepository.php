<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Collection;

class UserRepository
{
    /**
     * Get all users and paginate them
     *
     * @param int $paginate
     * @return Illuminate\Support\Collection
     */
    public function all($paginate)
    {
        return User::paginate($paginate);
    }

    /**
     * Main method for getting the visible users to a particular user
     *
     * @param App\User $user
     * @param string $search
     * @return Illuminate\Support\Collection
     */
    public function getVisibleUsers($user, $search = '')
    {
        if (!$user) {
            return new Collection;
        }

        switch ($user->role->machine_name) {
            case 'parent':
                $users = $this->getUsersVisibleToParent($user, $search)->except($user->id);
            break;
            case 'teacher':
                $users = $this->getUsersVisibleToTeacher($user, $search)->except($user->id);
            break;
            case 'coach':
                $users = $this->getUsersVisibleToMasterTeacher($user, $search);
            break;
            case 'school_leader':
                $users = $this->getUsersVisibleToSchoolLeader($user, $search)->except($user->id);
            break;
            case 'project_admin':
                $users = $this->getUsersVisibleToProjectAdmin($user, $search);
            break;
            case 'super_admin':
                $users = $this->getUsersVisibleToSuperAdmin($user, $search);
            break;
        }

        // Fetch admins
        $admins = User::where('role_id', '6')
            ->search($search)
            ->get();

        return $admins->merge($users);
    }

    /**
     * Gets all users that a parent is able to see
     *
     * @param App\User $user
     * @param string $search
     */
    protected function getUsersVisibleToParent($user, $search)
    {
        // Get teachers of their child
        $teachers = User::ofRoleType('teacher')
            ->inClassroom($user->classroom->name)
            ->search($search)
            ->get();

        // Get parents in their childs class
        $parents = User::ofRoleType('parent')
            ->inClassroom($user->classroom->name)
            ->search($search)
            ->get();

        return $parents->merge($teachers);
    }

    /**
     * Gets all users that a teacher is able to see
     *
     * @param App\User $user
     * @param string $search
     */
    protected function getUsersVisibleToTeacher($user, $search)
    {
        // Get all parents in their school
        $users = User::ofRoleType(['parent', 'teacher'])
            ->inSchools(collect([$user->classroom->school]))
            ->search($search)
            ->get();

        // Get their master teacher
        $masterTeachers = User::where('id', $user->masterteacher)
            ->search($search)
            ->get();

        return $masterTeachers->merge($users);
    }

    /**
     * Gets all users that a master teacher is able to see
     *
     * @param App\User $user
     * @param string $search
     */
    protected function getUsersVisibleToMasterTeacher($user, $search)
    {
        // Get all parents in their school
        $users = User::ofRoleType(['parent', 'teacher', 'school_leader'])
            ->inSchools(collect([$user->classroom->school]))
            ->search($search)
            ->get();

        // Get all master teachers
        $masterTeachers = User::ofRoleType(['coach'])
            ->search($search)
            ->get();

        return $users->merge($masterTeachers);
    }

    /**
     * Gets all users that a school leader is able to see
     *
     * @param App\User $user
     * @param string $search
     */
    protected function getUsersVisibleToSchoolLeader($user, $search)
    {
        // Get all master teachers, parents and teachers in their school
        $users = User::ofRoleType(['coach', 'parent', 'teacher'])
            ->inSchools(collect([$user->classroom->school]))
            ->search($search)
            ->get();

        // Get all school leaders
        $schoolLeaders = User::ofRoleType(['school_leader'])
            ->search($search)
            ->get();

        return $users->merge($schoolLeaders);
    }

    /**
     * Gets all users that a project admin is able to see
     *
     * @param App\User $user
     * @param string $search
     */
    protected function getUsersVisibleToProjectAdmin($user, $search)
    {
        return User::search($search)->get();
    }

    /**
     * Gets all users that a super admin is able to see
     *
     * @param App\User $user
     * @param string $search
     */
    protected function getUsersVisibleToSuperAdmin($user, $search)
    {
        return $this->getUsersVisibleToProjectAdmin($user, $search);
    }

    public function getUsers($ids) {
        return User::whereIn('id', $ids)->get();
    }
}
