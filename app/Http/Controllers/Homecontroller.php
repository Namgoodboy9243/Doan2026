<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Homecontroller extends Controller
{
    public function index(){
        return view('index');
    }

    public function category(){
        return view('category');
    }

    public function cart(){
        return view('cart');
    }
}
