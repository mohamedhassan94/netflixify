<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $latest_movies = Movie::latest()->where('description', '!=', null)->limit(5)->get();
        $categories = Category::get();

        $arr['latest_movies'] = $latest_movies;
        $arr['categories'] = $categories;

        if(Auth::user()){
            $favorite_movies = Auth::user()->movies->pluck('id')->toArray();
            $arr['favorite_movies'] = $favorite_movies;
        };

        return view('welcome', $arr);
    }
}
