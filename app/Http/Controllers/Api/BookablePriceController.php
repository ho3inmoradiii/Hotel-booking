<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id,Request $request)
    {
        $bookable = Bookable::findOrFail($id);

        $data = $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);
        $fromDate = Carbon::parse($data['from']);
        $toDate = Carbon::parse($data['to']);

        $days = $fromDate->diffInDays($toDate);

        $price = $days * $bookable->price;
        return response()->json([
            'data' => [
                'total' => $price,
                'breakdown' => [
                    $bookable->price => $days
                ]
            ]
        ]);
    }
}
