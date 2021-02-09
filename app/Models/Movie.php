<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'name',
        'description',
        'poster',
        'image',
        'path',
        'year',
        'rating',
        'percent'
    ];

    // scopes
    public static function scopeSearch($query, $searchTerm){
        return $query->where('name', 'like', '%' .$searchTerm. '%')
            ->orWhere('description', 'like', '%' .$searchTerm. '%')
            ->orWhere('year', 'like', '%' .$searchTerm. '%')
            ->orWhere('rating', 'like', '%' .$searchTerm. '%')
        ;
    }

    // relationships

    public function categories(){
        return $this->belongsToMany('App\Models\Category', 'movie_category');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_movie');
    }
}
