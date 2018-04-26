<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationRequest;
use App\Common\JResponse;
use App\Models\Ticket;

class TestController extends Controller{
    public function test(){
      $obj = Ticket::with('requester','agent','provider')->find(4);
      //Mail::to('alejandrogori00@gmail.com')->send(new ConfirmationRequest($obj));
      // Mail::send('emails.confirmreq', array('data' => $obj), function($message){
      //     $message->to('alejandrogori00@gmail.com', 'alejandrogori00@gmail.com')->subject('Welcome!');
      // });
      // return view('emails.confirmreq', ['data' => $obj]);

      try{
        Mail::send('emails.confirmreq', array('data' => $obj), function($message){
            $message->to('alejandrogori00@gmail.com', 'alejandrogori00@gmail.com')->subject('Welcome!');
        });
        return view('emails.confirmreq', ['data' => $obj]);
      }catch(\Exception $e){
        return $e;
      }
    }
}
