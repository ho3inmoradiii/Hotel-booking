<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
                if ($bookings !== 0) {
                    $fail('The object is not available in given dates');
                }
            }]
        ]));

        $bookingsData = $data['bookings'];
        $addressData = $data['customer'];

//        $bookable = Bookable::findOrFail($bookingsData[0]['bookable_id']);
//
//        $price = $bookable->priceFor($bookingsData[0]['from'],$bookingsData[0]['to']);

        //dd($price['data']['total']);

        $bookings = collect($bookingsData)->map(function ($bookingData) use ($addressData) {
            $bookable = Bookable::findOrFail($bookingData['bookable_id']);



            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $bookable->priceFor($booking->from,$booking->to)['data']['total'];
            $booking->bookable()->associate($bookable);

            $booking->address()->associate(Address::create($addressData));

            $booking->save();
            return $booking;
        });

        return $bookings;
    }
}
