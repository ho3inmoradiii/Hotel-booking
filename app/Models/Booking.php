<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    public function scopeFromDate($query, $from)
    {
        return $query->where('to','>=',$from);
    }

    public function scopeToDate($query, $to)
    {
        return $query->where('from','=<',$to);
    }

    use HasFactory;

    public function bookable(){
        return $this->belongsTo(Bookable::class);
    }

//    public function scopeBetweenDates(Builder $query,$from,$to){
//        return $query->where('to','>=',$from)
//            ->where('from','=<',$to);
//    }
}
