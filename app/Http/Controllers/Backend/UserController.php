<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreUserRequest;
use App\Http\Requests\Backend\UpdateUserRequest;
use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\MinistryDepartment;
use App\Models\MinistryOffices;
use App\Models\Role;
use App\Models\User;
use App\Services\Api\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Psy\debug;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::with('roles','local_government','ministry')->get();
        return view('Backend.user.index', compact("users"));
    }

    public function createUser()
    {
        return view('Backend.user.partials.add');
    }

    public function storeUser(StoreUserRequest $request)
    {
        if ($request->get('status') == true){
            $status = 1;
        }else
            $status = 0;

        $role = Role::where('slug', $request->get('role'))->first();
        $roleId = $role->id;
        $user = User::create([
            'parent_id' => 0,
            'type' => $request->get('type'),
            'lg_id' => $request->get('lg_role'),
            'ministry_id' => $request->get('ministry_role'),
            'ministry_department_id' => $request->get('ministry_department_role'),
            'office_id' => $request->get('ministry_office_role'),
            'name' => $request->get('first_name'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'phone_no' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
            'status' => $status,
        ]);
        $user->roles()->sync($roleId);

        return response()->json([
            'message' => 'User Data inserted Successfully',
            'data' => $user
        ], 200);
    }

    public function editUser($id)
    {
        $user = User::with('roles','local_government','ministry','ministry_office','ministry_department')->where('id', $id)->first();
        return view('Backend.user.partials.edit',compact('user'));
    }

    public function updateUser(UpdateUserRequest $request)
    {
        if ($request->get('status') == true){
            $status = 1;
        }else
            $status = 0;
        $role = Role::where('slug', $request->get('role'))->first();
        $roleId = $role->id;
        $user = User::findOrFail($request->get('id'));
        $user->update([
            'parent_id' => 0,
            'type' => $request->get('type'),
            'lg_id' => $request->get('lg_role'),
            'ministry_id' => $request->get('ministry_role'),
            'ministry_department_id' => $request->get('ministry_department_role'),
            'office_id' => $request->get('ministry_office_role'),
            'name' => $request->get('first_name'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'phone_no' => $request->get('phone'),
//            'password' => Hash::make($request->get('password')),
            'status' => $status,
        ]);
        $user->roles()->sync($roleId);
        return response()->json([
            'message' => 'Data Updated Successfully',
        ], 200);
    }

    public function deleteUser($id)
    {
        $user = User::where('id' , $id)->first();
        $user->delete();
        return redirect()->route('getAllUsers')->with('error','User Deleted');
    }

    public function getRoles()
    {
        $roles = Role::all();
        return response()->json([
            'message' => 'Data added Successfully',
            'data' => $roles
        ], 200);
    }

    public function getLgRoles()
    {
        $lgRoles = LocalGovernment::all();
        return response()->json([
            'message' => 'Data added Successfully',
            'data' => $lgRoles
        ], 200);
    }

    public function getMinistryRoles()
    {
        $ministryRoles = Ministry::all();
        return response()->json([
            'message' => 'Data added Successfully',
            'data' => $ministryRoles
        ], 200);
    }

    public function getMinistryOfficeRoles()
    {
        $ministryOfficeRoles = MinistryOffices::all();
        return response()->json([
            'message' => 'Data added Successfully',
            'data' => $ministryOfficeRoles
        ], 200);
    }

    public function getMinistryDepartmentRoles()
    {
        $ministryDepartmentRoles = MinistryDepartment::all();
        return response()->json([
            'message' => 'Data added Successfully',
            'data' => $ministryDepartmentRoles
        ], 200);
    }
}
