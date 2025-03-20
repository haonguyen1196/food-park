<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait FileUploadTrait {

    function uploadImage(Request $request, $inputName, $oldPath = NULL, $path = '/uploads')
    {
        if ($request->hasFile($inputName)) {
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$ext;

            $image->move(public_path($path), $imageName);

            /** delete old image file*/
            if ($oldPath && file_exists(public_path($oldPath))) {
                unlink(public_path($oldPath));
            }

            return $path.'/'.$imageName;
        }
        return null;
    }

    function removeImage($path)
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }

    }

}