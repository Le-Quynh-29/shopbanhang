<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Department;
use App\Repositories\Support\AbstractRepository;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use PhpParser\Node\Expr\FuncCall;

Paginator::useBootstrap();


class UserRepository extends AbstractRepository
{
    public function model()
    {
        return 'App\Models\User';
    }

    public function __construct(Container $app)
    {
        parent::__construct($app);
    }

    /**
     * check permission user
     *
     * @param mixed $id
     * @return void
     */
    public function editUser($id)
    {
        $user = Auth::user();
        $model = $this->model->find($id);
        if ($model->isNotAdmin() || !($user->isNotAdmin())) {
            return true;
        }
        return abort('403');
    }

    /**
     * Get list permission of user
     *
     * @param  mixed $user
     * @return void
     */
    public function getPermissionUser($user)
    {
        $permissionUserArr = [];

        $permissions = DB::table('users')
            ->join('permission_users', 'permission_users.user_id', 'users.id')
            ->join('permissions', 'permissions.id', 'permission_users.permission_id')
            ->where('users.id', $user->id)
            ->select('permissions.code')
            ->get();

        if (!$permissions->isEmpty()) {
            $permissionUserArr = array_column($permissions->toArray(), 'code');
        }

        return $permissionUserArr;
    }

    /**
     * Get all permission of user
     *
     * @param  mixed $user
     * @return void
     */
    public function getAllPermission($user)
    {
        $permissionUser = $this->getPermissionUser($user);
        $permissionDepartment = $this->getPermissionDepartment($user);
        $permissionPosition = $this->getPermissionPosition($user);

        $allPermission = array_unique(Arr::collapse([$permissionUser, $permissionDepartment, $permissionPosition]));

        return $allPermission;
    }

    /**
     * Check policy permission
     *
     * @param mixed $user
     * @param mixed $permission
     * @return void
     */
    public function checkPolicyPermission($user, $permission)
    {
        $isAdmin = $user->is_admin;
        if ($isAdmin == User::IS_ADMIN) {
            return true;
        } else {
            // Get all permission of user
            $permissionOfUser = $this->getAllPermission($user);
            if (!in_array($permission, $permissionOfUser)) {
                return false;
            }

            return true;
        }
    }


    /**
     * Check User to delete
     *
     * @param mixed $id
     * @return void
     */
    public function checkUser($id)
    {
        $user = User::where('id', '=', $id)->first();
        if ($user->is_admin == User::IS_ADMIN) {
            toastr()->error('Không thể xóa admin');
            return false;
        }

        return $id;
    }

    /**
     * deactivate User
     *
     * @param mixed $id
     * @return void
     */
    public function deactivate($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->update(['active' => User::INACTIVE]);

        return $user;
    }


    /**
     * activated User
     *
     * @param mixed $id
     * @return void
     */
    public function activated($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->update(['active' => User::ACTIVE]);

        return $user;
    }

    /**
     * give admin rights or remove admin rights

     *
     * @param mixed $id, $request
     * @return void
     */
    public function updateAdmin($id, $request)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->update(['is_admin' => $request]);

        return $user;
    }
}
