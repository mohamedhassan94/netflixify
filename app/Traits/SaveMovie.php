<?php

namespace App\Traits;

trait SaveMovie
{

    function saveMovie($request, $folderName, $disk){
        $movie = $request;
        $movieName = time().$movie->getClientOriginalName();
        $path = $movie->storeAs( $folderName , $movieName , $disk );
        return $path;
    }

}
