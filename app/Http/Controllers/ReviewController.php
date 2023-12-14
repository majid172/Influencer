<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
class ReviewController extends Controller
{
	public function review(Request $request)
	{
		$request->validate([
			'comment' => 'required',
			'rating' => 'required'
		]);
		$checkExist = Review::where('user_id',$request->user_id)->where('listing_id',$request->listing_id)->exists();
		if($checkExist)
		{
			return back()->with('error','Already review.');
		}
		$review = new Review();
		$review->user_id = $request->user_id;
		$review->influencer_id = $request->influencer_id;
		$review->listing_id = $request->listing_id;
		$review->ratings = $request->rating;
		$review->comment = $request->comment;
		$review->save();
		return back()->with('success','Review successfully.');
	}

}
