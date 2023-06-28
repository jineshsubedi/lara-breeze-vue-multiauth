<?php

namespace App\Http\Controllers\Staff;

use App\Enums\AppConstant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use App\Models\UserDetail;
use App\Models\District;
use App\Models\Education;
use App\Models\Faculty;
use App\Models\UserBank;
use Inertia\Inertia;
use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserKpi;
use App\Models\UserKra;

class ProfileController extends Controller
{
    protected $disk = 'public';
    protected $path = 'user';

    public function index()
    {
        $user = User::with(['documents','address','detail','bank', 'leducation'])->find(auth()->id());
        $user = request()->user();
        $document = [];
        foreach($user->documents as $k=>$doc)
        {
            $document[$k]['id'] = $doc->id;
            $document[$k]['title'] = $doc->title;
            $document[$k]['document'] = $doc->document;
            $document[$k]['document_path'] = $doc->document_path;
        }
        $detail = [
            'marital_status' => $user->detail ? $user->detail->marital_status : '',
            'citizenship_no' => $user->detail ? $user->detail->citizenship_no : '',
            'blood_group' => $user->detail ? $user->detail->blood_group : '',
        ];
        $address = [
            'pdistrict_id' => $user->address ? $user->address->pdistrict_id : '',
            'tdistrict_id' => $user->address ? $user->address->tdistrict_id : '',
            'p_address' => $user->address ? $user->address->p_address : '',
            't_address' => $user->address ? $user->address->t_address : '',
            'emergency_number' => $user->address ? $user->address->emergency_number : '',
            'primary_location' => $user->address ? $user->address->primary_location : '',
            'contact_person' => $user->address ? $user->address->contact_person : '',
            'contact_person_number' => $user->address ? $user->address->contact_person_number : '',
            'home_location' => $user->address ? $user->address->home_location : '',
            'phone_number' => $user->address ? $user->address->phone_number : '',
        ];
        $bank = [
            'account_number' => $user->bank ? $user->bank->account_number : '',
            'bank_name' => $user->bank ? $user->bank->bank_name : '',
            'pan_number' => $user->bank ? $user->bank->pan_number : '',
        ];
        $educated = [
            'education_level_id' => $user->leducation ? $user->leducation->education_level_id : '',
            'faculty_id' => $user->leducation ? $user->leducation->faculty_id : '',
            'specialization' => $user->leducation ? $user->leducation->specialization : '',
            'institution' => $user->leducation ? $user->leducation->institution : '',
            'year' => $user->leducation ? $user->leducation->year : '',
            'board' => $user->leducation ? $user->leducation->board : '',
            'marksystem' => $user->leducation ? $user->leducation->marksystem : '',
            'mark' => $user->leducation ? $user->leducation->mark : '',
        ];
        
        $user->avatarpath = $user->avatar_path;
        // return $user;
        $datas['genders'] = AppConstant::GENDER;
        $datas['marital_status'] = AppConstant::MARITAL_STATUS;
        $datas['education'] = Education::orderBy('title')->get(['id', 'title']);
        $datas['faculty'] = Faculty::orderBy('title')->get(['id', 'title']);
        $datas['mark_system'] = AppConstant::MARK_SYSTEM;

        $districts = District::get(['id', 'title']);
        $notification = request()->user()->notifications()->paginate(10);

        return Inertia::render('Staff/Profile', [
            'user' => $user,
            'datas' => $datas,
            'districts' => $districts,
            'detail' => $detail,
            'address' => $address,
            'bank' => $bank,
            'document' => $document,
            'notification' => $notification,
            'educated' => $educated
        ]);
    }
    public function updateProfile(ProfileRequest $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'nullable', 'required_with:confirm_password', 'same:confirm_password', Password::defaults()],
            'confirm_password' => ['sometimes', 'nullable', 'min:6'],
        ])->validate();
        User::find(auth()->id())->update([ 
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'father_name' => $request->father_name,
            'password' => $request->password != '' ? bcrypt($request->password) : auth()->user()->password,
        ]);
        UserAddress::updateOrCreate(['user_id' => auth()->id()],[
            'user_id' => auth()->id(),
            'pdistrict_id' => $request->pdistrict_id,
            'tdistrict_id' => $request->tdistrict_id,
            'p_address' => $request->p_address,
            't_address' => $request->t_address,
            'emergency_number' => $request->emergency_number,
            'primary_location' => $request->primary_location,
            'contact_person' => $request->contact_person,
            'contact_person_number' => $request->contact_person_number,
            'home_location' => $request->home_location,
            'phone_number' => $request->phone_number,
        ]);
        UserDetail::updateOrCreate(['user_id' => auth()->id()],[
            'user_id' => auth()->id(),
            'marital_status' => $request->marital_status,
            'citizenship_no' => $request->citizenship_no,
            'blood_group' => $request->blood_group,
        ]);
        UserBank::updateOrCreate(['user_id' => auth()->id()],[
            'user_id' => auth()->id(),
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'pan_number' => $request->pan_number,
        ]);
        UserEducation::updateOrCreate(['user_id' => auth()->id()],[
            'user_id' => auth()->id(),
            'education_level_id' => $request->education_level_id,
            'faculty_id' => $request->faculty_id,
            'specialization' => $request->specialization,
            'institution' => $request->institution,
            'year' => $request->year,
            'board' => $request->board,
            'marksystem' => $request->marksystem,
            'mark' => $request->mark,
        ]);
        if ($request->document)
        {
            foreach ($request->document as $key => $document)
            {
                $doc = '';
                if (isset($request->File('document')[$key]['document']))
                {
                    $directory = 'user/'.auth()->id().'/document';
                    if (!Storage::exists($directory)) {
                        Storage::makeDirectory($directory);
                    }
                    $file = $request->File('document')[$key]['document'];
                    $doc = $file->store($directory, $this->disk);
                    UserDocument::create([
                        'user_id' => auth()->id(),
                        'title' => $document['title'],
                        'document' => $doc
                    ]);
                }
            }
        }
        return Redirect::route('staffs.profile')->with('success', 'Profile Updated Successfully');
    }

    public function updateAvatar(Request $request)
    {
        Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg|max:2048'],
        ])->validate();

        $avatar = $request->file('avatar')->store($this->path, $this->disk);
        User::find(auth()->id())->update(['avatar' => $avatar]);
        return Redirect::route('staffs.profile');
    }
    public function deleteProfileDocument($id)
    {
        $doc = UserDocument::findOrFail($id);
        if($doc->document != '')
        {
            if (!Storage::exists($doc->document)) {
                Storage::makeDirectory($doc->document);
            }
        }
        $doc->delete();
        return back()->with('success', 'Document Deletd!');
    }
    public function saveKpi($id, Request $request)
    {
        $this->validate($request, [
            'category.*.title' => 'required|string'
        ]);
        foreach($request->category as $category)
        {
            UserKpi::create([
                'user_id' => $id,
                'title' => $category['title']
            ]);
        }
        return back();
    }
    public function deleteKpi($id)
    {
        UserKpi::findOrFail($id)->delete();
        return back();
    }
    public function saveKra($id, Request $request)
    {
        $this->validate($request, [
            'category.*.title' => 'required|string',
            'category.*.weightage' => 'required|integer',
        ]);
        foreach($request->category as $category)
        {
            UserKra::create([
                'user_id' => $id,
                'title' => $category['title'],
                'weightage' => $category['weightage']
            ]);
        }
        return back();
    }
    public function deleteKra($id)
    {
        UserKra::findOrFail($id)->delete();
        return back();
    }
}
