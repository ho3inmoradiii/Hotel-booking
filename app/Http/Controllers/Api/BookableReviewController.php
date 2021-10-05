<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $reviews = Review::where('bookable_id',$id)->latest()->get();
        return BookableReviewResource::collection($reviews);
    }
}
