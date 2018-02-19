<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\JResponse;

use Input;
use Carbon;

class TicketsController extends Controller{
    public function openTicket(){
        return response()->json(JResponse::set(true, '[obj]'), 200);
    }

    public function closeTicket(){
        return response()->json(JResponse::set(true, '[obj]'), 200);
    }
}
