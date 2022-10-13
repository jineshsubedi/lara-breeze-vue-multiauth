<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingRequest;
use App\Http\Controllers\Controller;
use App\Models\SettingSocial;
use Illuminate\Http\Request;
use App\Models\SettingEmail;
use App\Models\Setting;
use Inertia\Inertia;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::with(['emails', 'socials:setting_id,name,icon,url'])->first();
        $setting->logo_path = $setting->logo_path;
        $setting->icon_path = $setting->icon_path;
        return Inertia::render('Admin/Setting', ['setting' => $setting]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, Setting $setting)
    {
        $detail = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'item_perpage' => $request->item_perpage,
            'description_limit' => $request->description_limit,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'google_analytics' => $request->google_analytics,
            'logo' => $request->logo,
            'icon' => $request->icon,
        ];
        $setting->update($detail);
        if(isset($setting->id))
        {
            $emails = [
                'parameter' => $request->parameter,
                'host_name' => $request->host_name,
                'username' => $request->username,
                'password' => $request->password,
                'smtp_port' => $request->smtp_port,
                'encryption' => $request->encryption,
            ];
            SettingEmail::where('setting_id', $setting->id)->update($emails);
            // SettingSocial::where('Setting_id', $setting->id)->delete();
            if(count($request->socials) > 0)
            {
                foreach ($request->socials as $social) {
                    $updata = [
                        'name' => $social['name'],
                        'icon' => $social['icon'],
                        'url' => $social['url'],
                    ];
                    if(isset($social['setting_id']))
                    {
                        SettingSocial::where('setting_id', $social['setting_id'])->update($updata);
                    }else{
                        SettingSocial::create($updata + [
                            'setting_id' => $setting->id
                        ]);
                    }
                }
            }
        }
        return redirect()->route('admin.setting.index')->with('success', 'Setting Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
