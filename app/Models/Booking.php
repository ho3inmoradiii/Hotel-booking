<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\String_;

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

    public function reviews(){
        return $this->hasOne(Review::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public static function findByReviewKey(string $reviewKey){
        return static::where('review_key',$reviewKey)->with('bookable')->get()->first();
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function ($booking){
            $booking->review_key = Str::uuid();
        });
    }

//    public function scopeBetweenDates(Builder $query,$from,$to){
//        return $query->where('to','>=',$from)
//            ->where('from','=<',$to);
//    }
}
