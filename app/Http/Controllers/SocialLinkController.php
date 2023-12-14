<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function linkStore(Request $request)
	{
		$request->validate([
			'sitename' => 'required|string',
			'link' => 'required|string',
			'icon' => 'required',
		]);

		$social = new SocialLink();
		$social->user_id = $request->user_id;
		$social->sitename = $request->sitename;
		$social->link = $request->link;
		$social->icon = $request->icon;
		$social->save();
		return back()->with('success','Successfully add social link');

	}

	public function linkUpdate(Request $request,$linkId)
	{
		$request->validate([
			'sitename' => 'required|string',
			'link' => 'required|string',
			'icon' => 'required',
		]);
		$social = SocialLink::findOrFail($linkId);
		$social->user_id = $request->user_id;
		$social->sitename = $request->sitename;
		$social->link = $request->link;
		$social->icon = $request->icon;
		$social->save();
		return back()->with('success','Successfully updated social link');
	}

	public function linkDelete(Request $request,$linkId)
	{

		$social = SocialLink::findOrFail($linkId);
		$social->delete();
		return back()->with('success','Successfully delete social link');
	}
}
