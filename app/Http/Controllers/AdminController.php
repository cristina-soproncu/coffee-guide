<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coffee;
use Request;
use Session;

class AdminController extends Controller
{
    public function index(){
        $coffees=Coffee::all();
        return view('admin')->with('coffees',$coffees);
    }
}
