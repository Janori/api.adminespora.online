<?php

namespace App\Common;

class JResponse{

	public static function set($status, $msg, $data = null){
		$response = array('status'=>$status, 'msg'=>$msg, 'data'=>$data);
		return $response;
	}

	public static function saveModel($model, $returnsObject = false, $correctMsg = '', $correctStatus = 200){
		try{
			$model->save();
			//$obj = null;
			//if($returnsObject == true) $obj = $model;
			return response()->json(JResponse::set(true, '', ($returnsObject == true ? $model : null) ), $correctStatus); //,201
		}catch(\Exception $e){
			if($e->errorInfo[1] === 1062)
				return response()->json(JResponse::set(false, 'Entrada duplicada.' ), 400); //,500
			else
				return response()->json(JResponse::set(false, 'Datos incorrectos.', $e), 400); //,500
		}
	}

	public static function deleteModel($model){
		try{
			$model->delete();
			return response()->json(JResponse::set(true, ''), 202); //,202
		}catch(\Exception $e){
			return response()->json(JResponse::set(false, 'Datos incorrectos.', $e), 400); //,500
		}
	}

}
