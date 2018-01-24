<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Common\JResponse;
use App\Models\Land;
use App\Models\Warehouse;
use App\Models\Office;
use App\Models\Housing;
use App\Models\Building;
use App\Models\BuildingImages;


use Input;
use Carbon;
use Storage;

class BuildingController extends Controller{

    public static $building_type = [
      	['code' => 'c', 'name'=>'Casa', 'child'=>'house'],
        ['code' => 'x', 'name'=>'Sin definir', 'child'=>'all'],
  	];

    public function getTypes(){
      return response()->json(JResponse::set(true, '[keys]', BuildingController::$building_type), 200);
    }

    public function create(Request $request){

    	try {
            \DB::connection()->getPdo()->beginTransaction();
            $land = Land::create($request->all()['land']);
            $warehouse = Warehouse::create($request->all()['warehouse']);
            $office = Office::create($request->all()['office']);
            $housing = Housing::create($request->all()['housing']);
            $building = new Building($request->all());
            $building->land_id = $land->id;
  	        $building->warehouse_id = $warehouse->id;
  	        $building->house_id = $housing->id;
  	        $building->office_id = $office->id;
            /*$building = Building::create([
                "land_id" => $land->id,
                "warehouse_id" => $warehouse->id,
                "house_id" => $housing->id,
                "office_id" => $office->id,
                "extra_data" => $request->has('extra_data') ? $request->all()['extra_data'] : ""
            ]);*/
            $building->save();
            \DB::connection()->getPdo()->commit();
            return response()->json(JResponse::set(true, 'obj', $building), 201);
        } catch (\PDOException $e) {
            \DB::connection()->getPdo()->rollBack();
            return response()->json(JResponse::set(false, 'Datos incorrectos.', $e), 400);
        }
    }

    public function update(Request $request, $id){
    	if(is_null($id) || !is_numeric($id))
        return response()->json(JResponse::set(false, 'Error en la petición'), 400);
	    $obj = Building::find($id);
	    if($obj == null){
	      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
	    }
	    foreach ($request->all() as $key => $value){
        if($key == 'land' || $key == 'warehouse' || $key == 'office' || $key == 'housing'){
          //if($key == 'housing') $key = 'housing';
          if($obj->{$key}){
            $this->updateModel($obj->{$key}, $value);
            $obj->{$key}->save();
          }else{
            $temp = Land::create($request->all()['land']);
            $obj->{$key.'_id'} = $temp->id;
          }
        }else if(!is_null($value) && $key != 'id'){
	            $obj->{$key} = $value;
        }
      }
	    return JResponse::saveModel($obj, true, '', 200);

	}

  private function updateModel($obj, $dic){
    foreach ($dic as $key => $value){
      if(!is_null($value) && $key != 'id'){
            $obj->{$key} = $value;
      }
    }
  }

  public function getOne($id){
    if(is_null($id) || !is_numeric($id)){
      return response()->json(JResponse::set(false, 'Error en la petición'), 400);
    }
    $obj = Building::with('Land','Housing','Office','Warehouse', 'Images')->find($id);
    if($obj == null){
      return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);
    }
    return response()->json(JResponse::set(true, 'obj', $obj), 200);
  }

  public function search(Request $request){
      $from = $request->input('from', 0);
      $count = $request->input('count', 10);

      $query = Building::with('Land','Housing','Office','Warehouse');

      $k = $query->count();
      $objs = $query->get();

      return response()->json(JResponse::set(true, '[obj]', $objs), 200)->header('rowcount', $k);
  }

  public function loadImage(Request $request, $id){
      if(is_null($id) || !is_numeric($id))
         return response()->json(JResponse::set(false, 'Error en la petición'), 400);

      $fileName = Storage::disk('uploads')->put($id, $request->file('image'));
      $img = new BuildingImages();
      $img->building_id = $id;
      $img->path = 'uploads/' . $fileName;

      return JResponse::saveModel($img, true, '', 200);
  }

  public function deleteImage($image_id){
    if(is_null($image_id) || !is_numeric($image_id))
       return response()->json(JResponse::set(false, 'Error en la petición'), 400);

    $image = BuildingImages::find($image_id);
    if($image == null) return response()->json(JResponse::set(false, 'Recurso no encontrado'), 404);

    try{
      if(!Storage::disk('uploads')->delete(str_replace('uploads/', '',$image->path))){
        Log::warning('No se pudo eliminar el archivo: ' . $image->path . ', eliminar manualmente.', $e);
      }
    }catch(\Exception $e){
      Log::warning('No se pudo eliminar el archivo: ' . $image->path . ', eliminar manualmente.', $e);
    }

    return JResponse::deleteModel($image);
  }

  public function getImages($id){
    if(is_null($id) || !is_numeric($id))
       return response()->json(JResponse::set(false, 'Error en la petición'), 400);

    $query = BuildingImages::where('building_id', $id);

    $k = $query->count();
    $objs = $query->get();

    return response()->json(JResponse::set(true, '[obj]', $objs), 200)->header('rowcount', $k);
  }

	public function delete($id){
	    if(is_null($id) || !is_numeric($id))
	       return response()->json(JResponse::set(false, 'Error en la petición'), 400);
	    $obj = User::find($id);
	    if($obj == null)
           return response()->json(JResponse::set(false, 'Recurso no encontrado.'), 404);

      return JResponse::deleteModel($obj);
	}
}
