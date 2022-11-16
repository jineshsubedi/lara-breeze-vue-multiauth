<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        $setting = Setting::with(['socials'])->select('id', 'name', 'email', 'phone', 'address', 'meta_title', 'meta_keyword', 'meta_description', 'google_analytics', 'logo', 'icon')->first();
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => fn () => $request->user(),
                'avatar' => fn () => $request->user() ? $request->user()->avatar_path : '',
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'success' => fn () => session()->get('success'),
                'danger' => fn () => session()->get('danger'),
                'warning' => fn () => session()->get('warning'),
                'info' => fn () => session()->get('info')
            ],
            'can' => fn () => $request->user() ? $request->user()->roles->pluck('name') : [],
            'site' => fn () => $setting,
            'logo_path' => fn () => $setting->logo_path,
            'icon_path' => fn () => $setting->icon_path,
            'notifications' => $request->user() ? $request->user()->unreadNotifications : [],
            'countNotification' => $request->user() ? $request->user()->unreadNotifications->count() : 0,
        ]);
    }
}
