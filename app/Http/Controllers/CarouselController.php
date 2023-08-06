<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Carousel;
use Intervention\Image\Facades\Image;

class CarouselController extends Controller
{
    public function get()
    {
        $carousels = Carousel::get();
        $response = [
            'Data' => ['Carousels' => $carousels, 'IsSuccess' => true],
            'ErrorCode' => 0,
            'ErrorMessage' => 'Success',
        ];
        return response($response, 201);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
//            'description' => 'required',
        ]);
        $fileImage = $request->image;
        if ($fileImage) {
            $position = strpos($fileImage, ';');
            $sub = substr($fileImage, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = $request->image_name . '_' . time() ;
            $img = Image::make($fileImage)->resize(720, 300);
            $uploadPath = 'assets/carousel/' . $imageName . '.'. $ext;
            $img->save(public_path($uploadPath));
        }
        $carousel = new Carousel();
        $carousel->image = $uploadPath ?? 'assets/default.png';
        $carousel->save();
        $response = [
            'Carousel' => $carousel,
            'ErrorCode' => 0,
            'Message' => 'Success',
        ];
        return response($response, 201);
    }

    public function update(Request $request, $id)
    {
        $carousel = Carousel::findOrfail($id);
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = $request->imageName;
            $filename = time() . $imageName . "." . $ext;
            $img = Image::make($request->image);
            $uploadPath = 'assets/carousel/';
            if (!File::isDirectory($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true, true);
            }
            $uploadPathFolder = $uploadPath . $filename;
            $img->save(public_path($uploadPathFolder));
            $carousel->image = $uploadPathFolder;
        }
        $carousel->title = $request->title;
        $carousel->description = $request->description;
        $carousel->update();
        $response = [
            'Carousel' => $carousel,
            'ErrorCode' => 0,
            'Message' => 'Success',
        ];
        return response($response, 201);
    }
    public function delete($id) {
        $carousel = Carousel::where('id',$id)->first();
        $photo = $carousel->image;
        if($photo !== "assets/default.png" && public_path($photo)){
            $carousel->delete();
            unlink(public_path($photo));
        } else {
            $carousel->delete();
        }
        $response = [
            'Carousel' => $carousel,
            'ErrorCode' => 0,
            'Message' => 'Success',
        ];
        return response($response, 201);
    }
}
