<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index(Request $request){
        return new PropertyResource($request);
    }
}
