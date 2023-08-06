<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UploadHelperController extends Controller
{
    public function fileUpload($file, $location) {
        if (!empty($file)) {
            $position = strpos($file, ';');
            $sub = substr($file, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = '_' . time() ;
            $img = Image::make($file);
            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $uploadPath = $location . $imageName . '.'. $ext;
            $img->save(public_path($uploadPath));
        }
        return $uploadPath;
    }
    public function filesUpload($files, $location)
    {
        if (!empty($files)) {
            foreach($files as $file){
                $position = strpos($file, ';');
                $sub = substr($file, 0, $position);
                $ext = explode('/', $sub)[1];
                $imageName = '_' . time() ;
                $img = Image::make($file)->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $uploadPath = $location . $imageName . '.'. $ext;
                $img->save(public_path($uploadPath));
            }
        }
        return $location;
    }
    public function logoUpload($request, $uploadPath)
    {
        $position = strpos($request->logo_image, ';');
        $sub = substr($request->logo_image, 0, $position);
        $ext = explode('/', $sub)[1];
        $imageName = $request->logo_name . '_' . time() ;
        $img = Image::make($request->logo_image)->resize(300, 300);
        $locationPath = $uploadPath . $imageName . '.'. $ext;
        $img->save(public_path($locationPath));
        return $locationPath;
    }
}
