<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\LogTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

Paginator::useBootstrap();

class UserController extends Controller
{
    use LogTrait;
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize("viewAny", User::class);
        $users = $this->userRepo->all($request, false);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("create", User::class);

        return view("admin/user/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("create", User::class);
        $data = $request->except(['_token', '_method', '_url']);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['active'] = User::ACTIVE;
        $this->userRepo->create($data);
        toastr()->success('Tạo người dùng thành công.');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepo->find($id);
        if (is_null($user)) {
            abort(404);
        }
        $this->authorize('view', $user);

        return view("admin/user/show", compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepo->find($id);
        if (is_null($user)) {
            abort(404);
        }
        $this->authorize('update', $user);

        return view("admin/user/edit", compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $this->userRepo->find($id);
        if (is_null($user)) {
            abort(404);
        }
        $this->authorize('delete', $user);
        // Delete user
        $this->userRepo->delete($id);
        toastr()->success('Xóa người dùng thành công.');
        return $this->redirectAfterDelete($this->userRepo, $request, 'user.index');
    }

    /**
     * Update active user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lock(Request $request, $id)
    {
        $user = $this->userRepo->find($id);
        if (is_null($user)) {
            abort(404);
        }
        $this->authorize('update', $user);
        $data = $request->except(['_token', '_method', '_url']);
        // Update info user
        $this->userRepo->update($data, $id);
        toastr()->success('Cập nhật thông tin người dùng thành công.');
        return redirect()->back();
    }
}
