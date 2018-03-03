<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\JResponse;

use App\Models\Ticket;
use App\Http\Controllers\AuthController;
use Auth;

use Input;
use Carbon\Carbon;

class TicketsController extends Controller{

    public function test(){
      $obj = new Ticket();

      return response()->json(JResponse::set(true, 'obj', $obj), 200);
    }
    public function openTicket(Request $request){
      $obj = new Ticket($request->all());
      $obj->agent_id = Auth::user()->id;
      $obj->status = 'a';
      return JResponse::saveModel($obj, true, '', 201);
    }

    public function setProvider(Request $request, $id){
      if(is_null($id) || !is_numeric($id) || !$request->has('estimated_date'))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
	    $obj = Ticket::find($id);
	    if($obj == null){
	      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
	    }
      $obj->fill($request->only('provider_id', 'provider_cost', 'price'));
      $ed = $request->all()['estimated_date'];
      $obj->estimated_date = Carbon::now()->addWeeks($ed);
      $obj->status = 'c';
      $obj->request_hash = bcrypt($obj->id . $obj->requester_id . $obj->agent_id . $obj->building_id . $obj->provider_id);
      return JResponse::saveModel($obj, true, '', 202);
    }

    public function response(Request $request){
      $token = $request->get('token', null);
      $id = $request->get('id', null);
      $accepted = $request->get('accepted', null);
      if(is_null($id) || !is_numeric($id) || $token == null || $accepted == null){
        return response()->json(JResponse::set(false, 'Error al completar la solicitud.'));
      }
      $obj = Ticket::where('request_hash', $token)->where('id', $id)->get();
	    if($obj == null || count($obj) !== 1){
        return response()->json(JResponse::set(false, 'Error al completar la solicitud.'));
      }
      if($obj[0]->status != 'c'){
        return response()->json(JResponse::set(false, 'La solicitud ya se respondió previamente.', $obj[0]));
      }
      if(strtolower($accepted) == 'true'){
        $obj[0]->status = 'v';
      }else{
        $obj[0]->status = 'r';
      }
      return JResponse::saveModel($obj[0], true, '', 202);
    }

    public function closeTicket(){
        return response()->json(JResponse::set(true, '[obj]'), 200);
    }
}
