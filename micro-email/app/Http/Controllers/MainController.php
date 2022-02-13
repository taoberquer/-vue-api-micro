<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function confirmOrder(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required|email|max:255',
        ]);

        $data = array('name'=>'Arunkumar');
        Mail::send('mails.confirm_order', $data, function($message) {
            $message->to('easyselva@gmail.com', 'Arunkumar')->subject('Test Mail from Selva');
            $message->from('selva@snamservices.com','Selvakumar');
        });
        echo 'Email Sent. Check your inbox.';
    }
}
