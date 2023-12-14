<?php

namespace App\Http\Controllers\User;

use App\Models\ProfileInfo;
use Illuminate\Http\Request;
use App\Models\Certification;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class CertificationController extends Controller
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


	public function certificationInfoCreate(Request $request)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|string|min:3',
            'institution' => 'required|string|min:3',
            'start' => 'required|date',
            'end' => 'required|date|after:start'
        ];


        $validator = Validator::make($req, $rules);

        if ($validator->fails()) {
            $newArr = $validator->getMessageBag();
            $newArr->add('certificationCreateInfo', 1);

            return back()->withErrors($newArr)->withInput();
        }

        $data = new Certification();
        $data->user_id = auth()->user()->id;
        $data->name = $req['name'];
        $data->institution = $req['institution'];
        $data->start = $req['start'];
        $data->end = $req['end'];
        $data->save();

		$certificationInfo = ProfileInfo::firstOrNew(['user_id' => $this->user->id]);
        $certificationInfo->certification = 1;
        $certificationInfo->save();

        session()->put('name','certificationInfo');

        return redirect(url()->previous() . '#educationInfo')->with('success', 'Certification Info Added Successfully.');
    }


    public function certificationInfoUpdate(Request $request, $id)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required',
            'institution' => 'required',
            'start' => 'required',
            'end' => 'required|after:start'
        ];
        $message = [
            'name.required' => 'Name field is required',
            'institution.required' => 'Institution field is required',
            'start.required' => 'Start Date field is required',
            'end.required' => 'End Date field is required',
			'end.after' => 'End Date must be a date after Start Date',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr = $validator->getMessageBag();
            $newArr->add('certificationEditInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = Certification::findOrFail($id);
        $data->user_id = auth()->user()->id;
        $data->name = $req['name'];
        $data->institution = $req['institution'];
        $data->start = $req['start'];
        $data->end = $req['end'];
        $data->save();

        session()->put('name','certificationInfo');

        return redirect(url()->previous() . '#educationInfo')->with('success', 'Certification Info Updated Successfully.');
    }


    public function certificationInfoDelete($id)
    {
        $data = Certification::findOrFail($id);
        $data->delete();
        return redirect(url()->previous() . '#educationInfo')->with('success', 'Certification Info has been deleted');
    }

}
