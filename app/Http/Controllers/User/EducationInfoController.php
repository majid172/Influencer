<?php

namespace App\Http\Controllers\User;

use App\Models\ProfileInfo;
use Illuminate\Http\Request;
use App\Models\EducationInfo;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class EducationInfoController extends Controller
{
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


	public function educationInfoCreate(Request $request)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'degree' => 'required|string',
            'institution' => 'required|string',
            'start' => 'required|date',
            'end' => 'nullable|after:start'
        ];
        $message = [
            'degree.required' => 'Degree field is required',
            'institution.required' => 'Institution field is required',
            'start.required' => 'Start Date field is required',
			'end.after' => 'End Date must be a date after Start Date',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr = $validator->getMessageBag();
            $newArr->add('educationCreateInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = new EducationInfo();
        $data->user_id = auth()->user()->id;
        $data->degree = $req['degree'];
        $data->institution = $req['institution'];
        $data->start = $req['start'];
        $data->end = $req['end'];
        $data->save();

		$educationInfo = ProfileInfo::firstOrNew(['user_id' => $this->user->id]);
        $educationInfo->education = 1;
        $educationInfo->save();

        session()->put('name','educationInfo');

        return redirect(url()->previous() . '#userAddress')->with('success', 'Education Info Added Successfully.');
    }


    public function educationInfoUpdate(Request $request, $id)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'degree' => 'required|string|min:3',
            'institution' => 'required|string|min:3',
            'start' => 'required|date',
            'end' => 'nullable|after:start'
        ];
        $message = [
            'degree.required' => 'Degree field is required',
            'institution.required' => 'Institution field is required',
            'start.required' => 'Start Date field is required',
			'end.after' => 'End Date must be a date after Start Date',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr = $validator->getMessageBag();
            $newArr->add('educationUpdateInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = EducationInfo::findOrFail($id);
        $data->user_id = auth()->user()->id;
        $data->degree = $req['degree'];
        $data->institution = $req['institution'];
        $data->start = $req['start'];
        $data->end = $req['end'];

        $data->save();

        session()->put('name','educationInfo');

        return redirect(url()->previous() . '#userAddress')->with('success', 'Education Info Updated Successfully.');
    }


    public function educationInfoDelete($id)
    {

        $data = EducationInfo::findOrFail($id);
        $data->delete();
        return redirect(url()->previous() . '#userAddress')->with('success', 'Education Info has been deleted');
    }



}
