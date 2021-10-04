<?php

namespace App\Http\Controllers;

use App\Models\Bookable;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function show($id,Request $request){
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);

        dd($id);

        $bookable = Bookable::findOrFail($id);
        return $bookable->availableFor($data['from'],$data['to'])
            ? response()->json([]) : response()->json([],404);
    }
}
