<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\Language;

class SkillController extends Controller
{
	public function list()
	{
		$skills = Skill::get();
		return view('admin.skill.list',compact('skills'));
	}

	public function skillStore(Request $request)
	{
		$request->validate([
			'skill' => 'required|string'
		]);
		$skill = new Skill();
		$skill->skill = $request->skill;
		$skill->status = $request->status;
		$skill->save();
		return redirect()->back()->with('success','Skill stored successfully');
	}

	public function skillEdit($id)
	{

		$skill = Skill::find($id);
		return view('admin.skill.edit',compact('skill'));
	}
	public function skillUpdate(Request $request, $id)
	{
		$request->validate([
			'skill' => 'required|string'
		]);
		$skill = Skill::find($id);
		$skill->skill = $request->skill;
		$skill->status = $request->status;
		$skill->save();
		return redirect()->back()->with('success','Skill updated successfully.');

	}

	public function skillDelete($id)
	{
		$skill = Skill::find($id);
		$skill->delete();
		return redirect()->back()->with('success','Skill remove successfully.');
	}
}
