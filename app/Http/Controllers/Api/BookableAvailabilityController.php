<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function __invoke($id,Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d',
        ]);



        $bookable = Bookable::findOrFail($id);
        $bookings = $bookable->booking->where('to','>=',$data['from'])->where('from','<=',$data['to'])->count();
        if ($bookings === 0){
            $bookingStatus = true;
        } else{
            $bookingStatus = false;
        }

        return $bookingStatus ? response()->json([]) :response()->json([],404);
//
//        dd($bookingStatus);
//
//        return $bookable->availableFor($data['from'],$data['to'])
//            ? response()->json([]) : response()->json([],404);
    }
}
