<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function basic_email($mail,$data) {
     
	Mail::to($mail)->send(new SendMail($data));
    

   }
}
