<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    public function availableFor($from,$to){
        return $this->booking->fromDate($from)->toDate($to)->count();
    }
}
