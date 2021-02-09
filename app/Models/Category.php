<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ 'name' ];

    // attributes

    public function setNameAttribute($value){
        $name = strtolower($value);
        $this->attributes['name'] = ucwords($name);
    }

    // scopes
    public static function scopeSearch($query, $searchTerm){
        return $query->where('name', 'like', '%' .$searchTerm. '%');
    }

    // relationships

    public function movies(){
        return $this->belongsToMany('App\Models\Movie', 'movie_category');
    }

}
