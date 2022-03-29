<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Ajax\AjaxController;;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\LogTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

Paginator::useBootstrap();

class UserController extends AjaxController
{
    use LogTrait;

    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Check validate unique name
     *
     * @param  mixed $request
     * @return void
     */
    public function validateUniqueName(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('username');
        $data = $this->userRepo->validateUniqueName($id, $name);
        return $this->responseSuccess($data);
    }

    /**
     * Check validate unique email
     *
     * @param  mixed $request
     * @return void
     */
    public function validateUniqueEmail(Request $request)
    {
        $id = $request->get('id');
        $email = $request->get('email');
        $data = $this->userRepo->validateUniqueEmail($id, $email);
        return $this->responseSuccess($data);
    }

    /**
     * User autocomplete
     *
     * @return void
     */
    public function update(Request $request)
    {
        $id = $request->get('id');
        $user = $this->userRepo->find($id);
        abort_if(is_null($user), 404);
        $data = $request->except(['_token', '_method', '_url']);
        $password = $request->get('password');
        if (!is_null($password)) {
            $data['password'] = Hash::make($password);
        }
        $this->userRepo->update($data, $id);
        return $this->responseSuccess('success');
    }
}
