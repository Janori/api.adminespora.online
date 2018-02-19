<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\JResponse;
use App\Models\Payment;

use Input;
use Carbon;

class PaymentsController extends Controller{

  public function getOne($id){
    if(is_null($id) || !is_numeric($id)){
      return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    }
    $obj = Payment::find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }
    return response()->json(JResponse::set(true, 'obj', $obj), 200);
  }

  public function getAll(){
    $query = new Payment();

    $k = $query->count();
    $objs = $query->get();

    return response()->json(JResponse::set(true, '[obj]', $objs), 200)->header('rowcount', $k);
  }

}
