<?php

namespace App\Http\Controllers;

use App\Models\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class WelcomeController extends Controller
{
   public function index() {
       $page = Welcome::get();
       $response = [
           'Data' => ['Page' => $page, 'IsSuccess' => true],
           'ErrorCode' => 0,
           'ErrorMessage' => 'Success',
       ];
       return response($response, 201);
   }
   public function store(Request $request) {
       $request->validate([
          'title' => 'required',
          'title_desc' => 'required',
          'desc_one' => 'required',
          'desc_two' => 'required',
          'desc_three' => 'required',
       ]);
       if ($request->image) {
           $position = strpos($request->image, ';');
           $sub = substr($request->image, 0, $position);
           $ext = explode('/', $sub)[1];
           $imageName = $request->image_name;
           $filename = time() . $imageName . "."  . $ext;
           $img = Image::make($request->image);
           $uploadPath = 'assets/welcome/';
           if (!File::isDirectory($uploadPath)) {
               File::makeDirectory($uploadPath, 0777, true, true);
           }
           $uploadPathFolder = $uploadPath . $filename;
           $img->save(public_path($uploadPathFolder));
       }
       $page = new Welcome();
       $page->title = $request->title;
       $page->title_desc = $request->title_desc;
       $page->desc_one = $request->desc_one;
       $page->desc_two = $request->desc_two;
       $page->desc_three= $request->desc_three;
       $page->image= $uploadPathFolder;
       $page->save();
       $response = [
           'Carousel' => $page,
           'ErrorCode' => 0,
           'Message' => 'Success',
       ];
       return response($response, 201);
   }
   public function update(Request $request, $id) {
       $request->validate([
           'title' => 'required',
           'title_desc' => 'required',
           'desc_one' => 'required',
           'desc_two' => 'required',
           'desc_three' => 'required',
           'image' => 'required',
       ]);
       $page = Welcome::findOrfail($id);
       if ($request->image) {
           $position = strpos($request->image, ';');
           $sub = substr($request->Image, 0, $position);
           $ext = explode('/', $sub)[1];
           $imageName = $request->imageName;
           $filename = time() . $imageName . "." . $ext;
           $img = Image::make($request->image);
           $uploadPath = 'assets/welcome/';
           if (!File::isDirectory($uploadPath)) {
               File::makeDirectory($uploadPath, 0777, true, true);
           }
           $uploadPathFolder = $uploadPath . $filename;
           $img->save(public_path($uploadPathFolder));
           $page->image = $uploadPathFolder;
       }
       $page->title = $request->title;
       $page->title_desc = $request->title_desc;
       $page->desc_one = $request->desc_one;
       $page->desc_two = $request->desc_two;
       $page->desc_three = $request->desc_three;
       $page->update();
       $response = [
           'Carousel' => $page,
           'ErrorCode' => 0,
           'Message' => 'Success',
       ];
       return response($response, 201);
   }
   public function delete($id) {
       $page = Welcome::findOrfail($id);
       $photo = $page->image;
       if($photo !== 'default.png'){
           unlink(public_path($photo));
           $page->delete();
       }
       $page->delete();
       $response = [
           'Carousel' => $page,
           'ErrorCode' => 0,
           'Message' => 'Success',
       ];
       return response($response, 201);
   }
}
