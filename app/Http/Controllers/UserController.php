<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\JResponse;
use App\User;

use Input;
use Carbon;

class UserController extends Controller{
  public function search(Request $request){
    $from = $request->input('from', 0);
    $count = $request->input('count', 10);

    $query = User::with('role')->where(function($q) {

    });

    $k = $query->count();
    $objs = $query->get();

    return response()->json(JResponse::set(true, '[obj]', $objs), 200)->header('rowcount', $k);
  }

  public function getOne($id){
    if(is_null($id) || !is_numeric($id)){
      return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    }
    $obj = User::with('role')->find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }

    $query = User::with('role')->where(function($q) {

    });

    return response()->json(JResponse::set(true, 'obj', $obj), 200);
  }

  public function create(Request $request){
    $obj = new User($request->all());
    return JResponse::saveModel($obj, false, '', 201);
  }

  public function update(Request $request, $id){
    if(is_null($id) || !is_numeric($id))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    $obj = User::find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }

    foreach ($request->all() as $key => $value)
        if(!is_null($value) && $key != 'id')
            $obj->{$key} = $value;

    return JResponse::saveModel($obj, true, '', 200);

  }

  public function delete($id){
    if(is_null($id) || !is_numeric($id))
      return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    $obj = User::find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }
    return JResponse::deleteModel($obj);
  }
}
