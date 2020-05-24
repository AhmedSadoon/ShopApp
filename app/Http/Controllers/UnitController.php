<?php

namespace App\Http\Controllers;

use App\Model\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{


    public function index()
    {
        $units=Unit::paginate(env('PAGINATION_COUNT'));

        return view('admin.units.units')->with(['units'=>$units]);
    }
}
