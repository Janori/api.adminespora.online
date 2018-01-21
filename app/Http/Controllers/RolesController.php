<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Common\JResponse;

use Input;
use Carbon;

class RolesController extends Controller
{
    public function getAll(Request $request){
    	$objs = Role::all();
	    $k = $objs->count();
	    //$objs = $query->get();

	    return response()->json(JResponse::set(true, '[obj]', $objs), 200)->header('rowcount', $k);
	}
}
