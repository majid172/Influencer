<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Duration;

class DeadlineController extends Controller
{
    public function index()
	{
		$durations = Duration::orderBy('duration','asc')->get();
		return view('admin.duration.index',compact('durations'));
	}

	public function store(Request $request)
	{
		if($request->id)
		{
			$duration = Duration::find($request->id);
		}
		else{
			$duration = new Duration();
		}
		$duration->duration 	= $request->duration;
		$duration->frequency 	= $request->frequency;
		$duration->save();
		if($request->id)
		{
			return redirect()->back()->with('success','Duration updated successfully');

		}
		else{
			return redirect()->back()->with('success','Duration stored successfully');
		}


	}

	public function deadlineDelete($id)
	{

		$deadline = Duration::findOrFail($id);
		$deadline->delete();
		return redirect()->back()->with('success','Duration removed successfully');
	}
}
