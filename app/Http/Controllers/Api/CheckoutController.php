<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date',
            'bookings.*.to' => 'required|date',
            'customer.first_name' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.city' => 'required|min:2',
            'customer.street' => 'required|min:2',
        ]);

        $data = array_merge($data,$request->validate([
            'bookings.*' => ['required' , function ($attribute,$value,$fail) {
                $bookable = Bookable::findOrFail($value['bookable_id']);
                $bookings = $bookable->booking->where('to','>=',$value['from'])->where('from','<=',$value['to'])->count();
                if ($bookings === 0) {
                    $fail('The object is not available in given dates');
                }
            }]
        ]));
    }
}
