<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_settings')->only(['social_login' ,'social_links']);
        $this->middleware('permission:create_settings')->only([ 'store']);
    }

    public function social_login(){

        $social_sites = ['facebook', 'google'];
        $arr['social_sites'] = $social_sites;
        return view('layouts.dashboard.settings.social_login', $arr);
    }

    public function social_links(){
        $social_sites = ['facebook', 'youtube', 'twitter'];
        $arr['social_sites'] = $social_sites;
        return view('layouts.dashboard.settings.social_links', $arr);
    }

    public function store(Request $request){
        setting( $request->all() )->save();
        return back()->with('message', 'data added successfully');
    }
}
