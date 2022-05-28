<?php

namespace App\Http\Controllers;

use App\Mail\signupvalidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class controlleemail extends Controller
{
    public static function signupemail($name ,$email,$validationcode)
    {
        $data=[
            'name'=>$name,
            'validationcode'=>$validationcode
        ];
        Mail::to($email)->send(new signupvalidation($data));
    }
}
