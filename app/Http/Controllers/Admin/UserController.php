<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\ListUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(ListUserRequest $request)
    {
        $users = resolve(UserRepository::class)->getUsers($request);

        return view('admin.pages.user.listUsers', compact('users'));
    }

    public function show($id)
    {
        $user = resolve(UserRepository::class)->getUser($id);

        return view('admin.pages.user.showUser', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        if (!$request->password) {
            unset($request['password']);
        } else {
            $request['password'] = Hash::make($request->password);
        }
        unset($request['_token']);
        $data = $request->all();
        $user = resolve(UserRepository::class)->updateUser($id, $data);

        return redirect()->back()->with('status', 'Cập nhật thành công');;
    }

    public function destroy($id)
    {
        resolve(UserRepository::class)->deleteUser($id);

        return redirect()->route('admin.users');
    }

    public function getLogin($id)
    {
        $user = resolve(UserRepository::class)->getUser($id);

        \Auth::login($user);

        return redirect()->route('home');
    }
}
