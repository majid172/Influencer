<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManageDay;
use Illuminate\Http\Request;

class AddDayController extends Controller
{
	public function index()
	{
		$data['day'] = ManageDay::firstOrFail();
		return view('admin.add_days',$data);
	}
	public function update(Request $request)
	{
		$request->validate([
			'days'=>'required|numeric'
		]);
		$day = ManageDay::firstOrFail();
		$day->days = $request->days;
		$day->save();
		return back()->with('success','Day changed successfully');
	}
}
