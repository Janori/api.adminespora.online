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
      $obj = Ticket::with('requester','agent','provider')->find(4);

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
      if(is_numeric($ed))
        $obj->estimated_date = Carbon::now()->addWeeks($ed);
      $obj->status = 'c';
      $obj->request_hash = bcrypt($obj->id . $obj->requester_id . $obj->agent_id . $obj->building_id . $obj->provider_id);

      $resp = false;
      try{
          $resp = $this->_sendMail($obj);
      }catch(\Exception $e){}

      return JResponse::saveModel($obj, true, $resp, 202);
    }

    private function _sendMail($obj){
      if(!$obj->email_sended) return false;
      if($obj->email_sended == true) return true;
      try{
        \Mail::send('emails.confirmreq', array('data' => $obj), function($message){
            $message->to('alejandrogori00@gmail.com', 'alejandrogori00@gmail.com')->subject('Welcome!');
        });
        $obj->email_sended = true;
        $obj->save();
        return true;
      }catch(\Exception $e){
        $obj->email_sended = false;
        $obj->save();
        return false;
      }
    }

    public function sendMail(Request $request, $id){
      if(is_null($id) || !is_numeric($id) || !$request->has('estimated_date'))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
	    $obj = Ticket::find($id);
	    if($obj == null){
	      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
	    }
      //Mail::to('alejandrogori00@gmail.com')->send(new ConfirmationRequest($obj));
      try{
        Mail::send('emails.confirmreq', array('data' => $obj), function($message){
            $message->to('alejandrogori00@gmail.com', 'alejandrogori00@gmail.com')->subject('Solicitud de mantenimiento.');
        });
        return response()->json(JResponse::set(true, 'Correo enviado correctamente.'));
      }catch(\Exception $e){
        return response()->json(JResponse::set(false, 'Error al enviar el correo.'));
      }
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

    public function closeTicket(Request $request, $id){
      if(is_null($id) || !is_numeric($id))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
	    $obj = Ticket::find($id);
	    if($obj == null){
	      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
	    }
      $obj->fill($request->only('status', 'extra'));
      $obj->finalized_date = Carbon::now();
      return JResponse::saveModel($obj, true, '', 202);
    }
}

/*
  v = aceptado
  r = rechazado
  c = cotizado
  a = activo
  x = cancelado
  f = finalizado

*/
