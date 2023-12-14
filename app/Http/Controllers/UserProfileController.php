<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Employment;
use App\Models\Hire;
use App\Models\Portfolio;
use App\Models\SocialLink;
use App\Models\State;
use App\Models\Testimonial;
use App\Traits\Upload;
use App\Models\Country;
use App\Models\Language;
use App\Models\ProfileInfo;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\Certification;
use App\Models\EducationInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
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

	public function changePassword(Request $request)
	{
		if ($request->isMethod('get')) {
			return view($this->theme.'user.profile.change');
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'currentPassword' => 'required|min:5',
				'password' => 'required|min:8|confirmed',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$user = Auth::user();
			$purifiedData = (object)$purifiedData;

			if (!Hash::check($purifiedData->currentPassword, $user->password)) {
				return back()->withInput()->withErrors(['currentPassword' => 'current password did not match']);
			}

			$user->password = bcrypt($purifiedData->password);
			$user->save();
			return back()->with('success', 'Password changed successfully');
		}
	}


	public function index()
	{
		$data['user'] = $this->user;
		$data['userProfile'] = UserProfile::firstOrCreate(['user_id' => $data['user']->id]);
		$data['languages'] = Language::select('id', 'name')->where('is_active', true)->orderBy('name', 'ASC')->get();
		$data['educationInfo'] = EducationInfo::where('user_id', auth()->user()->id)->get();
		$data['certificationInfo'] = Certification::where('user_id', auth()->user()->id)->get();

		$data['array_of_knownLanguage'] = json_decode($data['userProfile']->known_languages);
        $data['countries'] = Country::get(["name", "id"]);

        $data['profileComplete'] = getProfileCompletedPercentage($this->user->id);
		$data['socialInfo'] = SocialLink::where('user_id',$this->user->id)->get();
		$data['portfolios'] = Portfolio::where('user_id',$this->user->id)->get();
		$data['employments'] = Employment::where('user_id',$this->user->id)->get();
		$data['testimonials'] = Testimonial::where('user_id',$this->user->id)->get();
		$data['work_history'] = Hire::where('proposser_id',$this->user->id)->where('is_hired',1)->get();
        $data['approvedProfile'] = ProfileInfo::select('status')->where('user_id', $this->user->id)->firstOrFail();

		return view($this->theme . 'user.profile.show', $data);
	}

	public function profileInfo(Request $request)
	{
		$request->validate([
			'name' => 'required|string',
			'email' => 'required|email',
			'date_of_birth' => 'required|string',
			'phone_number' => 'required|string'
		]);

		$user = $this->user;
		$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);

		$user->name = $request->name;
		$user->email = $request->email;
		$user->profile->phone = $request->phone_number;
		$user->profile->date_of_birth = $request->date_of_birth;

		if ($request->file('cover_picture') && $request->file('cover_picture')->isValid()) {
			$extension = $request->cover_picture->extension();
			$profileName = strtolower($user->username . '_cover' . '.' . $extension);
			$image = $this->fileUpload($request->cover_picture, config('location.cover.path'), $userProfile->driver, $profileName, $userProfile->cover_picture);
			if ($image) {

				$userProfile->cover_picture =  $image['path'] ?? null;
				$userProfile->driver = $image['driver'] ?? null;
			}
		}
		$user->save();
		$user->profile->save();
		$userProfile->save();

		return back()->with('success','Profile information update successfully.');
	}

	public function profilePicture(Request $request)
	{
		$user = $this->user;
		$userProfile = UserProfile::where('user_id',$user->id)->firstOrFail();
		$profile_picture = $request->image;

			$extension = $profile_picture->extension();
			$profileName = strtolower($user->username . '_profile' . '.' . $extension);
			$image = $this->fileUpload($profile_picture, config('location.user.path'), $userProfile->driver, $profileName, $userProfile->profile_picture);
			if ($image) {
				$userProfile->profile_picture =  $image['path'] ?? null;
				$userProfile->driver = $image['driver'] ?? null;
				$userProfile->save();
			}


		return back()->with('success','Profile picture updated');

	}

	public function additionalInfo(Request $request)
	{
		$request->validate([
			'about_me' => 'required|string',
		]);
		$user = $this->user;
		$user->profile->about_me = $request->about_me;
		$user->profile->save();
		return back()->with('success','Profile information update successfully.');

	}

	public function skillsUpdate(Request $request)
	{
		$request->validate([
			'skills'=>'required',
		]);
		$user = $this->user->profile;
		$user->skills = $request->skills;
		$user->save();
		return back()->with('success','User skills update successfully');

	}

	public function languageUpdate(Request $request)
	{
		$request->validate([
			'known_languages'=>'required',
		]);

		$user = $this->user;
		$user->profile->mother_tongue = $request->mother_tongue;
		$user->profile->known_languages = implode(',',$request->known_languages);
		$user->profile->save();
		return back()->with('success','Language change successfully');
	}

	public function designationUpdate(Request $request)
	{
		$request->validate([
			'designation' => 'required|string',
			'hourly_rate' => 'required|numeric',
			'about_me' => 'required|string|max:500',
		]);
		$user = $this->user;
		$userProfile = UserProfile::where('user_id',$user->id)->firstOrFail();
		$userProfile->designation = $request->designation;
		$userProfile->hourly_rate = $request->hourly_rate;
		$userProfile->about_me = $request->about_me;
		$userProfile->save();
		return back()->with('success','Successfully updated');
	}


	public function workRemove(Request $request)
	{
		$work = Hire::findOrFail($request->id);
		$work->delete();
		return back()->with('success','Work history remove.');
	}


	// start country-state-city dependency dropdown
	public function getCountry()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view($this->theme . 'user.profile.show', $data);
    }

    public function getState(Request $request)
    {
        $data['states'] = State::where("country_id",$request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function getCity(Request $request)
    {
        $data['cities'] = City::where("state_id",$request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
	// end country-state-city dependency dropdown

	public function address(Request $request){

        $req = Purify::clean($request->except('_token', '_method'));
		$user = $this->user;
		$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);

        $rules = [
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'city_id' => 'nullable|integer|exists:cities,id',
            'zip_code' => 'nullable|integer',
            'address' => 'required'
        ];
        $message = [
            'country_id.required' => 'Country field is required',
            'state_id.required' => 'State field is required',
            'address.required' => 'Address field is required'
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
			$newArr = $validator->getMessageBag();
            $newArr->add('userAddress', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $userProfile->country_id = $req['country_id'];
        $userProfile->state_id = $req['state_id'];
        $userProfile->city_id = $req['city_id'];
        $userProfile->zip_code = $req['zip_code'];
        $userProfile->address = $req['address'];
        $userProfile->save();

		$address = ProfileInfo::firstOrNew(['user_id' => $user->id]);
        $address->address = 1;
        $address->save();
        session()->put('name','userAddress');

        return redirect(url()->previous() . '#saveUserPersonalInfo')->with('success', 'Address Updated Successfully.');
    }


}
