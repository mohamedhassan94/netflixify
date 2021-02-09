<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index(Request $request){

        $category = Category::where('name', request()->category_name)->first();

        if($request->ajax()){
            $movies = Movie::search($request->search)->get();
            foreach($movies as $movie){
                $movie['poster'] = url('/uploads/pictures/'.$movie->poster);
            }
            return $movies;
        }else{
            $movies = Movie::whereHas('categories', function($q) use ($category){
                return $q->where( 'category_id', $category->id );
            })->get();
            $arr['movies'] = $movies;
        };

        if(Auth::user()){
            $favorite_movies = Auth::user()->movies->pluck('id')->toArray();
            $arr['favorite_movies'] = $favorite_movies;
        };

        return view('movies.index',$arr);
    }

    public function show($id){
        $movie = Movie::findOrFail($id);
        $related_movies = Movie::where('id', '!=', $movie->id)->whereHas('categories', function($q) use($movie){
            return $q->whereIn( 'category_id', $movie->categories->pluck('id')->toArray() );
        })->limit(5)->get();

        if(Auth::user()){
            $favorite_movies = Auth::user()->movies->pluck('id')->toArray();
            $arr['favorite_movies'] = $favorite_movies;
        };
        $arr['movie'] = $movie;
        $arr['related_movies'] = $related_movies;

        return view('movies.show',$arr);
    }

    public function increment_views($id){
        $movie = Movie::findOrFail($id);
        $movie->increment('views');
    }

    public function toggle_favorite($id){
        $movie = Movie::findOrFail($id);
        $user = Auth::user();

        $is_favored = User::where('id', '=', $user->id)->whereHas('movies', function($q) use($movie){
            return $q->where('movie_id', $movie->id );
        })->count();

        if( $is_favored ){
            $movie->users()->detach($user->id);
        }else{
            $movie->users()->attach($user->id);
        }
    }

    public function favorite_movies(){
        $user = Auth::user();

        $movies = Movie::whereHas('users', function($q) use ($user){
            return $q->where( 'user_id', $user->id );
        })->get();

        $arr['movies'] = $movies;

        if(Auth::user()){
            $favorite_movies = Auth::user()->movies->pluck('id')->toArray();
            $arr['favorite_movies'] = $favorite_movies;
        };

        return view('movies.favorite',$arr);
    }

}
