<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\JResponse;
use App\Models\Customer;

use Input;
use Carbon;

class CustomerController extends Controller
{
  public function search(Request $request){
    $from = $request->input('from', 0);
    $count = $request->input('count', 10);
    $kind = $request->input('kind', null);
    $word = $request->input('word', null);

    $query = Customer::where(function($q) use($kind, $word) {
      if($kind != null){
        $q->where('kind', $kind);
      }
      if($word != null){
        $q->where(function($q) use($word){
          $q->where('name', 'like', $word . '%');
          $q->orWhere('first_surname', 'like', $word . '%');
          $q->orWhere('last_surname', 'like', $word . '%');
        });
      }
    });

    $k = $query->count();
    $objs = $query->get();

    return response()->json(JResponse::set(true, '[obj]', $objs), 200)->header('rowcount', $k);
  }

  public function create(Request $request){
    $obj = new Customer($request->all());
    return JResponse::saveModel($obj, false, '', 201);
  }

  public function update(Request $request, $id){
    if(is_null($id) || !is_numeric($id))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    $obj = Customer::find($id);
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
    $obj = Customer::find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }
    return JResponse::deleteModel($obj);
  }
}
