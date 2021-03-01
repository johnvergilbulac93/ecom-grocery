<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowMenuController extends Controller
{
    public function index()
    {
        return view('report');
    }
    public function showMenu()
    {
        return view('layouts.master');
    }
}
