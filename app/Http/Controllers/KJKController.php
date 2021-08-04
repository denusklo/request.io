<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FirebaseController;

class KJKController extends Controller
{
    public function createRequest()
    {
        return view('users.createRequest');
    }



    public function viewRequest()
    {
        return view('users.viewRequest');
    }
}
