<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\JResponse;
use App\Models\Rents;
use App\Models\Building;
use App\Models\Payment;
use App\Http\Controllers\AuthController;

use Input;
use Carbon\Carbon;
use Storage;

class RentsController extends Controller{

  public function initRent(Request $request){
    $obj = new Rents($request->all());
    $obj->user_id = AuthController::getUserFromToken($request->get("Authorization"))->id;
    return JResponse::saveModel($obj, true, '', 201);
  }

  public function getOne($id){
    if(is_null($id) || !is_numeric($id)){
      return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    }
    $obj = Rents::find($id); //with('renter')->
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }
    return response()->json(JResponse::set(true, 'obj', $obj), 200);
  }

  public function getAll(){
    $query = new Rents();

    $k = $query->count();
    $objs = $query->get();

    return response()->json(JResponse::set(true, '[obj]', $objs), 200)->header('rowcount', $k);
  }

  public function updateRent(Request $request, $id){
    if(is_null($id) || !is_numeric($id))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    $obj = Rents::find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }

    $obj->fill($request->all());

    return JResponse::saveModel($obj, true, '', 200);
  }

  public function cancelRent(){

  }

  public function completeRent(Request $request, $id){
    if(is_null($id) || !is_numeric($id) || !$request->has('pdf'))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    $obj = Rents::find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }
    $fileName = null;
    try {
        \DB::connection()->getPdo()->beginTransaction();

        $building = Building::find($obj->building_id);
        $building->is_rented = true;
        $building->save();

        $payment = new Payment();
        for($i = 1; $i <= $obj->rent_period; $i++){
          $payment->charge_to = $obj->renter_id;
          $payment->pay_to = $building->owner_id;
          $payment->building_id = $building->id;
          $payment->charge = $obj->price;
          $payment->charge_payment = 0;
          $payment->paying = $obj->price * (100 - $building->com_percent) / 100;
          $payment->paying_payment = 0;
          $payment->due_date = (new Carbon($obj->start_date))->addMonths($i);
          $payment->kind = 'r';
          $payment->save();
          $payment = new Payment();
        }

        $obj->status = "r";

        $fileName = Storage::disk('local')->put($id, $request->file('pdf'));
        $obj->contract_path = $fileName;

        $obj->save();
        \DB::connection()->getPdo()->commit();
        return response()->json(JResponse::set(true, 'obj', $obj), 200);
    } catch (\PDOException $e) {
        \DB::connection()->getPdo()->rollBack();
        if($fileName != null){
          Storage::disk('local')->delete($fileName);
        }
        return response()->json(JResponse::set(false, 'Datos incorrectos.', $e), 400);
    }

  }

  public function getPDF($id){
    if(is_null($id) || !is_numeric($id))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    $obj = Rents::find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }
    if($obj->contract_path == null){
      return response()->json(JResponse::set(false, 'No se ha podido encontrar un contrato cargado para esta renta.'), 404);
    }else if(!Storage::disk('local')->exists($obj->contract_path)){
      return response()->json(JResponse::set(false, 'El contrato ha cambiado de nombre o no existe.'), 404);
    }

    $file = storage_path('app/' . $obj->contract_path);
    return response()->download($file);
  }

  public function genPDF(Request $request){
    return response()->json(JResponse::set(true, 'PDFDummy', "No funciona aún"), 200);
  }

}
