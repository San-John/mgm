<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Header;
use Illuminate\Http\Request;

class HeaderController extends UploadHelperController
{
    public function get()
    {
        $carousels = Header::get();
        $response = [
            'Data' => ['Headers' => $carousels, 'IsSuccess' => true],
            'ErrorCode' => 0,
            'ErrorMessage' => 'Success',
        ];
        return response($response, 201);
    }
    public function update(Request $request, $id) {
        $field = $request->validate([
            'sc_facebook' => 'required|string',
            'sc_linkedin' => 'required|string',
            'sc_instagram' => 'required|string',
            'sc_youtube' => 'required|string',
            'sc_twitter' => 'required|string',
            'sc_whatsapp' => 'required|string',
            'sc_email' => 'required|string',
            'logo_name' => 'required|string',
        ]);
        $header = Header::findOrfail($id);
        $uploadPath = 'assets/header/';
       $imagePath = $this->singleUpload($request, $uploadPath);
        $header->sc_facebook = $field['sc_facebook'];
        $header->sc_linkedin = $field['sc_linkedin'];
        $header->sc_instagram = $field['sc_instagram'];
        $header->sc_youtube = $field['sc_youtube'];
        $header->sc_twitter = $field['sc_twitter'];
        $header->sc_whatsapp = $field['sc_whatsapp'];
        $header->sc_email = $field['sc_email'];
        $header->logo_image = $imagePath;
        $header->logo_name = $field['logo_name'];
        $header->save();
        $response = [
            'Header' => $header,
            'ErrorCode' => 0,
            'Message' => 'Success',
        ];
        return response($response, 200);
    }
}
