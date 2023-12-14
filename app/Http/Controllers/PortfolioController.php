<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
	use Upload;
	public $user, $theme;

	public function __construct()
	{
		$this->middleware(['auth']);
		$this->middleware(function ($request, $next) {
			$this->user = auth()->user();
			return $next($request);
		});
		$this->theme = template();
	}

	public function store(Request $request)
	{
		$rules = [
			'title' => 'required|string|min:8',
			'completion_date' => 'required|string|date',
			'url' => 'required|string',
			'skills' => 'required|string',
			'description' => 'required|string|min:8|max:500'
		];

		$validator = Validator::make($request->all(),$rules);;

		if ($validator->fails()) {
			$newArr = $validator->getMessageBag();
			$newArr->add('portfolioCreateInfo', 'portfolio error');
			dd($newArr);
			return back()->withErrors($newArr)->withInput();
		}

		$portfolio = new Portfolio();
		$portfolio->user_id = $this->user->id;
		$portfolio->project_title = $request->title;
		$portfolio->completion_date = $request->completion_date;
		$portfolio->project_url = $request->url;
		$portfolio->skills = $request->skills;
		if ($request->image) {
			try {
				$image = $this->fileUpload($request->image, config('location.portfolio.path'),null);
				if ($image) {
					$portfolio->image = $image['path'] ?? null;
					$portfolio->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $e) {
				return back()->with('alert', 'Image could not be uploaded');
			}
		}
		$portfolio->description = $request->description;

		$portfolio->save();
		return redirect()->route('user.profile')->with('success','Portfolio stored successfully.');
	}

	public function update(Request $request)
	{
		$rules = [
			'title' => 'required|string|min:8',
			'completion_date' => 'required|string',
			'url' => 'required|string',
			'skills' => 'required|string',
			'description' => 'required|string|min:8|max:500'
		];

		$validator = Validator::make($request->all(),$rules);;

		if ($validator->fails()) {
			$newArr = $validator->getMessageBag();
			$newArr->add('portfolioUpdateInfo', 'error');
			return back()->withErrors($newArr)->withInput();
		}

		$portfolio = Portfolio::findOrFail($request->id);
		$portfolio->project_title = $request->title;
		$portfolio->completion_date = $request->completion_date;
		$portfolio->project_url = $request->url;
		$portfolio->skills = $request->skills;
		if ($request->image) {
			try {
				$image = $this->fileUpload($request->image, config('location.portfolio.path'),null);
				if ($image) {
					$portfolio->image = $image['path'] ?? null;
					$portfolio->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $e) {
				return back()->with('alert', 'Image could not be uploaded');
			}
		}
		$portfolio->description = $request->description;

		$portfolio->save();
		return redirect()->route('user.profile')->with('success','Portfolio stored successfully.');
	}

	public function cancel(Request $request,$id)
	{
		$portfolio = Portfolio::findOrFail($id);
		dd($portfolio);
		$portfolio->delete();
		$portfolio->save();
		return back()->with('success','Successfully removed portfolio');
	}
}
