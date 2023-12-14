<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\CouponDetails;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
	public function couponList()
	{
		$allCoupon = Coupon::with('details')->latest()->get();
		return view('admin.coupon.couponList', compact('allCoupon'));
	}


	public function couponCreate()
	{
		$languages = Language::all();
		return view('admin.coupon.couponCreate', compact('languages'));
	}


	public function couponStore(Request $request, $language)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'name.*' => 'required|max:20|unique:coupon_details,name',
			'type' => 'required|numeric|in:0,1',
			'code' => 'required|unique:coupons|max:40',
			'amount' => 'required|gt:0|numeric',
		];

		$message = [
			'name.*.required' => 'Coupon Name field is required',
			'name.*.unique' => 'Coupon Name has already been taken.',
			'name.*.max' => 'Coupon Name field may not be greater than :max characters.',
			'code.required' => 'Coupon Code field is required',
			'code.unique' => 'Coupon Code has already been taken.',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$coupon = new Coupon();
		$coupon->type = $request->type;
		$coupon->code = $request->code;
		$coupon->amount = $request->amount;
		$coupon->status = $request->status;
		$coupon->save();

		$coupon->details()->create([
			'language_id' => $language,
			'name' => $purifiedData["name"][$language],
		]);

		return redirect()->route('admin.coupon.index')->with('success', 'Coupon Successfully Saved');
	}


	public function couponEdit($id)
	{
		$languages = Language::all();
		$couponDetails = CouponDetails::with('coupon')->where('coupon_id', $id)->get()->groupBy('language_id');

		return view('admin.coupon.couponEdit', compact('languages', 'couponDetails', 'id'));
	}


	public function couponUpdate(Request $request, $id, $language_id)
	{

		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'name.*' => ['required','max:20',Rule::unique(CouponDetails::class,'name')->whereNotIn('coupon_id',[$id])->whereNotIn('language_id',[$language_id])],
			'type' => 'sometimes|required|numeric|in:0,1',
			'code' => ['sometimes','required', 'max:40', Rule::unique(Coupon::class, 'code')->ignore($id)],
			'amount' => 'sometimes|required|gt:0|numeric',
		];

		$message = [
			'name.*.required' => 'Coupon Name field is required',
			'name.*.unique' => 'Coupon Name has already been taken.',
			'name.*.max' => 'Coupon Name field may not be greater than :max characters.',
			'code.required' => 'Coupon Code field is required',
			'code.unique' => 'Coupon Code has already been taken.',
		];
		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$coupon = Coupon::findOrFail($id);
		if ($request->has('type')) {
			$coupon->type = $request->type;
		}
		if ($request->has('code')) {
			$coupon->code = $request->code;
		}
		if ($request->has('amount')) {
			$coupon->amount = $request->amount;
		}
		if ($request->has('status')) {
			$coupon->status = $request->status;
		}

		$coupon->save();

		$coupon->details()->updateOrCreate([
			'language_id' => $language_id
		],
			[
				'name' => $purifiedData["name"][$language_id],
			]
		);

		return redirect()->route('admin.coupon.index')->with('success', 'Coupon Successfully Updated');
	}


	public function couponDelete($id)
	{
		$couponDelete = Coupon::findOrFail($id);
		$couponDelete->delete();

		return back()->with('success', 'Coupon has been deleted');
	}

}
