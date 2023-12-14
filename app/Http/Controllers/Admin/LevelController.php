<?php

namespace App\Http\Controllers\Admin;

use App\Models\Level;
use App\Traits\Upload;
use App\Models\Language;
use App\Models\LevelDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
	use Upload;

    public function levelList()
	{
		$allLevel = Level::with('details')->latest()->get();

		return view('admin.level.levelList', compact('allLevel'));
	}


	public function levelCreate()
	{
		$languages = Language::all();
		return view('admin.level.levelCreate', compact('languages'));
	}


	public function levelStore(Request $request, $language)
	{
		$purifiedData = Purify::clean($request->except('image', '_token', '_method'));

		$rules = [
			'name.*' => 'required|max:20',
			'minimum_complete_orders' => 'required|integer',
			'minimum_earn_amount' => 'required|numeric',
			'add_extra_services' => 'required|integer',
			'withdraw_earnings' => 'required|integer',
			'image' => 'max:3072|mimes:jpg,jpeg,png'
		];

		$message = [
			'name.*.required' => 'Level Name field is required',
			'name.*.max' => 'Level Name field may not be greater than :max characters.',
			'minimum_complete_orders.required' => 'Minimum Completed Orders field is required',
			'minimum_complete_orders.integer' => 'Minimum Completed Orders field must be an integer value',
			'minimum_earn_amount.required' => 'Minimum Earn Amount field is required',
			'minimum_earn_amount.numeric' => 'Minimum Earn Amount field must be a numeric value',
			'add_extra_services.required' => 'Add Extra Services field is required',
			'add_extra_services.integer' => 'Add Extra Services field must be an integer value',
			'withdraw_earnings.required' => 'Withdraw Earnings field is required',
			'withdraw_earnings.integer' => 'Withdraw Earnings field must be an integer value',
			'image.required' => 'Image is required',
			'image.mimes' => 'This image must be a file of type: jpg, jpeg, png.',
			'image.max' => 'This image may not be greater than :max kilobytes.',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$level = new Level();
		$level->minimum_complete_orders = $request->minimum_complete_orders;
		$level->minimum_earn_amount = $request->minimum_earn_amount;
		$level->add_extra_services = $request->add_extra_services;
		$level->withdraw_earnings = $request->withdraw_earnings;
		$level->status = $request->status;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.level.path'));
				if ($image) {
					$level->image =  $image['path'] ?? null;
					$level->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$level->save();

		$level->details()->create([
			'language_id' => $language,
			'name'        => $purifiedData["name"][$language],
		]);

		return redirect()->route('admin.level.index')->with('success', 'Level Successfully Saved');
	}


	public function levelEdit($id){
		$languages = Language::all();
		$levelDetails = LevelDetails::with('level')->where('level_id', $id)->get()->groupBy('language_id');

		return view('admin.level.levelEdit', compact('languages', 'levelDetails', 'id'));
	}


	public function levelUpdate(Request $request, $id, $language_id){

		$purifiedData = Purify::clean($request->except('image','_token', '_method'));

		$rules = [
			'name.*' => 'required|max:20',
			'minimum_complete_orders' => 'sometimes|required|integer',
			'minimum_earn_amount' => 'sometimes|required|numeric',
			'add_extra_services' => 'sometimes|required|integer',
			'withdraw_earnings' => 'sometimes|required|integer',
			'image' => 'sometimes|required|max:3072|mimes:jpg,jpeg,png'
		];

		$message = [
			'name.*.required' => 'Level Name field is required',
			'name.*.max' => 'Level Name field may not be greater than :max characters.',
			'minimum_complete_orders.required' => 'Minimum Completed Orders field is required',
			'minimum_complete_orders.integer' => 'Minimum Completed Orders field must be an integer value',
			'minimum_earn_amount.required' => 'Minimum Earn Amount field is required',
			'minimum_earn_amount.numeric' => 'Minimum Earn Amount field must be a numeric value',
			'add_extra_services.required' => 'Add Extra Services field is required',
			'add_extra_services.integer' => 'Add Extra Services field must be an integer value',
			'withdraw_earnings.required' => 'Withdraw Earnings field is required',
			'withdraw_earnings.integer' => 'Withdraw Earnings field must be an integer value',
			'image.required' => 'Image is required',
			'image.mimes' => 'This Image must be a file of type: jpg, jpeg, png.',
			'image.max' => 'This Image may not be greater than :max kilobytes.',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$level = Level::findOrFail($id);
		if ($request->has('minimum_complete_orders')) {
			$level->minimum_complete_orders = $request->minimum_complete_orders;
		}
		if ($request->has('minimum_earn_amount')) {
			$level->minimum_earn_amount = $request->minimum_earn_amount;
		}
		if ($request->has('add_extra_services')) {
			$level->add_extra_services = $request->add_extra_services;
		}
		if ($request->has('withdraw_earnings')) {
			$level->withdraw_earnings = $request->withdraw_earnings;
		}
		if ($request->has('status')) {
			$level->status = $request->status;
		}

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.level.path'), $level->driver, null, $level->image);
				if ($image) {
					$level->image =  $image['path'] ?? null;
					$level->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$level->save();

		$level->details()->updateOrCreate([
			'language_id' => $language_id
		],
			[
				'name' => $purifiedData["name"][$language_id],
			]
		);

		return redirect()->route('admin.level.index')->with('success', 'Level Successfully Updated');
	}


	public function levelDelete($id){
		$levelDelete = Level::findOrFail($id);
		$this->fileDelete($levelDelete->driver, $levelDelete->image);
		$levelDelete->delete();

		return back()->with('success', 'Level has been deleted');
	}

}
