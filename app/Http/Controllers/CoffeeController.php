<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coffee;
use Request;
use Session;

class CoffeeController extends Controller
{
    public function index(){
        $coffees=Coffee::all();
        return view('blog')->with('coffees',$coffees);
    }
}
