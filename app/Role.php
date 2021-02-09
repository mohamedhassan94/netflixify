<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    public static function scopeSearch($query, $searchTerm){
        return $query->where('name', 'like', '%' .$searchTerm. '%');
    }
}
