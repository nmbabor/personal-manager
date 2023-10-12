<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\ValidImageType;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHandlerController;
use App\Models\Country;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('country')->latest();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->addColumn('created', function ($data) {
                    return date('d M, Y', strtotime($data->created_at));
                })
                ->addColumn('country_name', function ($data) {
                    return $data->country->name ?? '';
                })
                ->addColumn(
                    'action',
                    '<div class="action-wrapper">
                    <a class="btn btn-sm bg-success"
                        href="{{ route(\'deposit.user-details\', $id) }}">
                        <i class="fas fa-eye"></i>
                    </a>
                     <a class="btn btn-sm bg-gradient-primary"
                        href="{{ route(\'backend.admin.user.edit\', $id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-sm bg-gradient-danger"
                        href="{{ route(\'backend.admin.user.delete\', $id) }}"
                        onclick="return confirm(\'Are you sure ?\')">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    @if ($is_suspended)
                        <a class="btn btn-sm bg-gradient-success"
                            href="{{ route(\'backend.admin.user.suspend\', [\'id\' => $id, \'status\' => 0]) }}">
                            <i class="fas fa-check-square"></i>
                            Activate
                        </a>
                    @else
                        <a class="btn btn-sm bg-gradient-warning"
                            href="{{ route(\'backend.admin.user.suspend\', [\'id\' => $id, \'status\' => 1]) }}"
                            onclick="return confirm(\'Are you sure ?\')">
                            <i class="far fa-times-circle"></i>
                            Suspend
                        </a>
                    @endif
                    
                </div>'
                )
                ->addColumn('suspend', function ($data) {
                    if ($data->is_suspended == 0) {
                        return '<span class="badge badge-pill badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-pill badge-danger">Suspended</span>';
                    }
                })
                ->rawColumns(['thumb', 'created', 'action', 'suspend'])
                ->toJson();
        }

        return view('backend.users.index');
    }

    public function fetchPageData(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('type', 'User')->latest()->paginate(10);

            return view('backend.users.user-table-data', compact('users'))->render();
        }
    }

    public function suspend($id, $status)
    {
        $user = User::findOrFail($id);

        if ($user->is_suspended == $status) {
            return back()->with('error', 'User already suspended');
        } else {
            $user->is_suspended = $status;
            $user->save();

            return back()->with('success', 'User suspended successfully');
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'mobile_no' => 'required|unique:users,mobile_no',
                'type' => 'required',
                'password' => 'required',
                'profile_image' => ['file', new ValidImageType]
            ]);
            $input = $request->except('_token');
            $input['password'] = bcrypt($request->password);
            $input['username'] = uniqid();
            $input['join_date'] = date('Y-m-d',strtotime($request->join_date));
            $input['deposit_start_date'] = date('Y-m-d',strtotime($request->deposit_start_date));

            if ($request->hasFile("profile_image")) {
                $input['profile_image'] = uploadImageAndGetPath($request->file("profile_image"), "/assets/images/users");
            }
            User::create($input);

           /*  $role = Role::find($request->role);
            $newUser->syncRoles($role); */

            return to_route('backend.admin.users')->with('success', 'User created successfully');
        } else {
            $country = Country::whereStatus(1)->pluck('name','id');
            $words = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9];
            return view('backend.users.create',compact('country','words'));
        }
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'type' => 'required',
                'profile_image' => ['file', new ValidImageType]
            ]);
            $input = $request->except('_token');

            if ($request->email !== $user->email) {
                $input['google_id'] = null;
                $input['is_google_registered'] = false;
            }


            if ($request->hasFile("profile_image")) {
                secureUnlink($user->profile_image);

                $input['profile_image'] = uploadImageAndGetPath($request->file("profile_image"), "/assets/images/users");
            }
            $input['join_date'] = date('Y-m-d',strtotime($request->join_date));
            $input['deposit_start_date'] = date('Y-m-d',strtotime($request->deposit_start_date));
            $user->update($input);

           /*  $role = Role::find($request->role);
            $user->syncRoles($role); */
            
            return to_route('backend.admin.users')->with('success', 'User updated successfully');
        } else {
            if ($id == auth()->id()) {
                return to_route('user.profile');
            }
            $country = Country::whereStatus(1)->pluck('name','id');
            $words = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9];
            return view('backend.users.edit', compact('user','country','words'));
        }
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            return back()->with('error', 'Can not delete your self');
        }
        if ($id == 1) {
            return back()->with('error', 'Can not delete master account');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted');
    }
}
