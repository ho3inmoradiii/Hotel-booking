<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Bookable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function availableFor($from,$to){
        return $this->booking->fromDate($from)->toDate($to)->count();
    }

    public function priceFor($from,$to) {
        $fromDate = Carbon::parse($from);
        $toDate = Carbon::parse($to);

        $days = $fromDate->diffInDays($toDate) + 1;

        $price = $days * $this->price;

        return [
            'data' => [
                'total' => $price,
                'breakdown' => [
                    $this->price => $days
                ]
            ]
        ];
    }
}
