<?php

namespace App\Http\Controllers;

use App\Model\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states=State::with(['Country'])->paginate(env('PAGINATION_COUNT'));
        return view('admin.States.states')->with([
            'states'=>$states,
        ]);
    }
}
