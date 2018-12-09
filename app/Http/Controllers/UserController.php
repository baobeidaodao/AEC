<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 16:26
 */

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $active = 'user';

    public function index(Request $request)
    {
        $userList = User::all()->toArray();
        $data = [];
        $data['active'] = $this->active;
        $data['userList'] = $userList;
        return view('user.index', $data);
    }

    public function create()
    {
        $data = [];
        $data['active'] = $this->active;
        return view('user.create', $data);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|max:255',
        ])->validate();
        $user = (new User)->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        if ($request->role) {
            $user->attachRoles($request->role);
        }
        return redirect('admin/user');
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            $user = $user->toArray();
        } else {
            $user = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['user'] = $user;
        return view('user.show', $data);
    }

    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            $user = $user->toArray();
        } else {
            $user = [];
        }
        $data = [];
        $data['active'] = $this->active;
        $data['user'] = $user;
        return view('user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
        ])->validate();
        $user = (new User)->findOrFail($id);
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => (isset($request->password) && !empty($request->password)) ? bcrypt($request->password) : $user->password,
        ])->save();
        if ($roleArray = $request->role) {
            $user->roles()->sync($roleArray);
        } else {
            $user->roles()->detach();
        }
        if (User::isAdmin($user)) {
            $admin = (new Role)->where('name', '=', Role::getAdmin())->first();
            $user->attachRole($admin);
        }
        return redirect('admin/user');
    }

    public function destroy($id)
    {
        $user = (new User)->findOrFail($id);
        // $role->perms()->detach();
        try {
            $user->delete();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/user');
    }
}