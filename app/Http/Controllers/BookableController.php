<?php

namespace App\Http\Controllers;

use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableController extends Controller
{
    public function bookables(){
        $bookables = Bookable::all();
        return $bookables;
    }

    public function show(Request $request,$id){
        $bookable = Bookable::findOrFail($id);
        return $bookable;
    }
}
