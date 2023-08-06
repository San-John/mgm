<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function get()
    {
        $user = auth()->user();
        if ($user->role === 'admin'){
            $users = User::where('id', '!=', $user->id)->get();
        } else {
            $users = User::where('id', '=', $user->id)->get();
        }
        $Result = [
            'Message' => 'Success',
            'Users' => $users,
        ];
        return $this->sendResponse($Result);
    }
}
