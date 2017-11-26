<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\JResponse;

class TestController extends Controller{
    public function test(){
      return response()->json(
        JResponse::set(true, "Hola", "Como estas?"), 200
      );
    }
}
