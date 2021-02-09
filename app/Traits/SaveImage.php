<?php

namespace App\Traits;

trait SaveImage
{

    function saveImage($request, $folderName, $disk){
        $image = $request;
        $imageName = preg_replace("/[^a-zA-Z]+/", "", time().$image->getClientOriginalName());
        $path = $image->storeAs( $folderName , $imageName , $disk );
        return $path;
    }

}
