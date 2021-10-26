<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OutController extends Controller
{
    public function __construct()
    {

    }


    public function index()
    {

        return view('welcome');

    }
}
