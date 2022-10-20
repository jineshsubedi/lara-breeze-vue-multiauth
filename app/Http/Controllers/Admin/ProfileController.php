<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected $disk = 'public';
    protected $path = 'user';

    public function index()
    {
        $user = User::with(['documents','address','detail','bank'])->find(auth()->id());
        $user->avatarpath = $user->avatar_path;

        $datas['genders'] = ['Male','Female'];
        $datas['marital_status'] = ['Married','Unmarried'];
        $districts = District::pluck('id', 'title');

        return Inertia::render('Admin/Profile', [
            'user' => $user,
            'datas' => $datas,
            'districts' => $districts,
        ]);
    }
    public function updateProfile(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'nullable', 'min:6', 'required_with:confirm_password', 'same:confirm_password'],
            'confirm_password' => ['sometimes', 'nullable', 'min:6'],
        ])->validate();
        User::find(auth()->id())->update([ 
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password != '' ? bcrypt($request->password) : auth()->user()->password,
        ]);
        return Redirect::route('admin.profile')->with('success', 'Profile Updated Successfully');
    }

    public function updateAvatar(Request $request)
    {
        Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg|max:2048'],
        ])->validate();

        $avatar = $request->file('avatar')->store($this->path, $this->disk);
        User::find(auth()->id())->update(['avatar' => $avatar]);
        return Redirect::route('admin.profile');
    }
}
