<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Movie;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        $users_count = User::count();
        $roles_count = Role::count();
        $categories_count = Category::count();
        $movies_count = Movie::where('percent', 100)->count();

        $arr['users_count'] = $users_count;
        $arr['roles_count'] = $roles_count;
        $arr['categories_count'] = $categories_count;
        $arr['movies_count'] = $movies_count;

        return view('layouts.dashboard.welcome', $arr);
    }
}
