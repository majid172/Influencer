<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmploymentController extends Controller
{

	public function store(Request $request)
	{
		$rules = [
			'title' => 'required|string|min:8',
			'city' => 'required|string',
			'company' => 'required|string|min:3',
			'from_period' => 'required|date',
		];

		$validator = Validator::make($request->all(),$rules);;

		if ($validator->fails()) {
			$newArr = $validator->getMessageBag();
			$newArr->add('employmentCreateInfo', 'error');
			return back()->withErrors($newArr)->withInput();
		}


		$employment = new Employment();
		$employment->user_id = auth()->user()->id;
		$employment->title = $request->title;
		$employment->company = $request->company;
		$employment->city = $request->city;
		$employment->country_id = $request->country_id;
		$employment->from_period = $request->from_period;
		$employment->to_period = $request->present??$request->to_period;
		$employment->description = $request->description;
		$employment->save();
		return redirect()->route('user.profile')->with('success','Employment history successfully stored.');
	}

	public function update(Request $request)
	{
		$rules = [
			'title' => 'required|string|min:8',
			'city' => 'required|string',
			'company' => 'required|string|min:3',
			'from_period' => 'required|date',
		];

		$validator = Validator::make($request->all(),$rules);;

		if ($validator->fails()) {
			$newArr = $validator->getMessageBag();
			$newArr->add('employmentUpdateInfo', 'error');
			return back()->withErrors($newArr)->withInput();
		}

		$employment = Employment::findOrFail($request->id);
		$employment->title = $request->title;
		$employment->company = $request->company;
		$employment->city = $request->city;
		$employment->country_id = $request->country_id;
		$employment->from_period = $request->from_period;
		$employment->to = $request->to_period??$request->present;
		$employment->description = $request->description;
		$employment->save();
		return redirect()->route('user.profile')->with('success','Employment history successfully stored.');
	}

	public function remove(Request $request)
	{
		$employment = Employment::findOrFail($request->id);

		$employment->delete();
		return redirect()->route('user.profile')->with('success','Employment history successfully removed');
	}
}
