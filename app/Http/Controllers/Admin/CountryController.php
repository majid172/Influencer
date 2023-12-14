<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class CountryController extends Controller
{
    public function countryList()
    {
        $countryList = Country::orderBy('name','ASC')->get();
        return view('admin.country.countryList', compact('countryList'));
    }


    public function countryCreate()
    {
        return view('admin.country.countryCreate');
    }


    public function countryStore(Request $request)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|max:20|unique:countries,name',
        ];
        $message = [
            'name.required' => 'Country Name field is required',
            'name.max' => 'Country Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $countryStore = new Country();
        $countryStore->name = $purifiedData["name"];
        $countryStore->save();

        return redirect()->route('admin.countryList')->with('success', 'Country Saved Successfully');
    }


    public function countryEdit($id)
    {
        $countryList = Country::where('id', $id)->get();
        return view('admin.country.countryEdit', compact('countryList', 'id'));
    }


    public function countryUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|max:25',
        ];
        $message = [
            'name.required' => 'Country Name field is required',
            'name.max' => 'Country Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $country = Country::findOrFail($id);
        $country->name = $purifiedData["name"];
        $country->save();

        return redirect()->route('admin.countryList')->with('success', 'Country Updated Successfully');
    }


    public function countryDelete($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

		$relatedState = State::where('country_id', $id)->get();

		if ($relatedState) {
			foreach ($relatedState as $key => $state) {
				$relatedAllCityToDelete = City::where('state_id', $state->id)->get();
				foreach ($relatedAllCityToDelete as $key => $city) {
					$relatedCityToDelete = City::where('id', $city->id)->firstOrFail();
					if ($relatedCityToDelete) {
						$relatedCityToDelete->delete();
					}
				}

				$relatedStateToDelete = State::where('id', $state->id)->firstOrFail();
				if ($relatedStateToDelete) {
					$relatedStateToDelete->delete();
				}
			}
		}

        return back()->with('success', 'Country Deleted Successfully');
    }



    // State
    public function stateList()
    {
        $stateList = State::with('country')->orderBy('id','DESC')->paginate(config('basic.paginate'));
        return view('admin.country.stateList', compact('stateList'));
    }


    public function stateCreate()
    {
        $countryList = Country::orderBy('name','ASC')->get();
        return view('admin.country.stateCreate',compact('countryList'));
    }


    public function stateStore(Request $request)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'country_id' => 'required',
            'name' => 'required|max:25',
        ];
        $message = [
            'country_id.required' => 'Please Select a Country',
            'name.required' => 'State Name field is required',
            'name.max' => 'State Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $state = new State();
        $state->country_id = $purifiedData["country_id"];
        $state->name = $purifiedData["name"];
        $state->save();

        return redirect()->route('admin.stateList')->with('success', 'State Saved Successfully');
    }


    public function stateEdit($id)
    {
        $countryList = Country::orderBy('name','ASC')->get();
        $stateList = State::with('country')->where('id', $id)->get();
        return view('admin.country.stateEdit', compact('stateList', 'id', 'countryList'));
    }


    public function stateUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'country_id' => 'required',
            'name' => 'required|max:25',
        ];
        $message = [
            'country_id.required' => 'Please Select a Country',
            'name.required' => 'State Name field is required',
            'name.max' => 'State Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $state = State::findOrFail($id);
        $state->country_id = $purifiedData["country_id"];
        $state->name = $purifiedData["name"];
        $state->save();

        return redirect()->route('admin.stateList')->with('success', 'State Updated Successfully');
    }


    public function stateDelete($id)
    {
        $state = State::findOrFail($id);
		$state->delete();

		$relatedCity = City::where('state_id', $id)->get();
		if ($relatedCity) {
			foreach ($relatedCity as $key => $city) {
				$relatedCityToDelete = City::where('id', $city->id)->firstOrFail();
				if ($relatedCityToDelete) {
					$relatedCityToDelete->delete();
				}
			}
		}

        return back()->with('success', 'State Deleted Successfully');
    }



    public function stateSearch(Request $request)
    {
        $search = $request->all();

        $stateList = State::with('country')->orderBy('id', 'DESC')
            ->when(isset($search['country_name']), function ($query) use ($search) {
                return $query->whereHas('country', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search['country_name']}%");
                });
            })
            ->when(isset($search['state_name']), function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search['state_name']}%");
            })
            ->paginate(config('basic.paginate'));

        $stateList =  $stateList->appends($search);

        return view('admin.country.stateList', compact('stateList'));
    }



    // City
    public function cityList()
    {
        $cityList = City::with('state.country')->orderBy('id','DESC')->paginate(config('basic.paginate'));
        return view('admin.country.cityList', compact('cityList'));
    }


    public function cityCreate()
    {
        $stateList = State::orderBy('id','DESC')->get();
        return view('admin.country.cityCreate',compact('stateList'));
    }


    public function cityStore(Request $request)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'state_id' => 'required',
            'name' => 'required|max:25'
        ];
        $message = [
            'state_id.required' => 'Please Select a State',
            'name.required' => 'City Name field is required',
            'name.max' => 'City Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $city = new City();
        $city->state_id = $purifiedData["state_id"];
        $city->name = $purifiedData["name"];
        $city->save();

        return redirect()->route('admin.cityList')->with('success', 'City Saved Successfully');
    }


    public function cityEdit($id)
    {
        $stateList = State::orderBy('id','DESC')->get();
        $cityList = City::with('state')->where('id', $id)->get();
        return view('admin.country.cityEdit', compact('stateList', 'id', 'cityList'));
    }


    public function cityUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'state_id' => 'required',
            'name' => 'required|max:25',
        ];
        $message = [
            'state_id.required' => 'Please Select a State',
            'name.required' => 'City Name field is required',
            'name.max' => 'City Name may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $city = City::findOrFail($id);
        $city->state_id = $purifiedData["state_id"];
        $city->name = $purifiedData["name"];
        $city->save();

        return redirect()->route('admin.cityList')->with('success', 'City Updated Successfully');
    }


    public function cityDelete($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return back()->with('success', 'City Deleted Successfully');
    }


    public function citySearch(Request $request)
    {
        $search = $request->all();

        $cityList = City::with('state')->orderBy('id', 'DESC')
            ->when(isset($search['country_name']), function ($query) use ($search) {
                return $query->whereHas('country', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search['country_name']}%");
                });
            })
            ->when(isset($search['state_name']), function ($query) use ($search) {
                return $query->whereHas('state', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search['state_name']}%");
                });
            })
            ->when(isset($search['city_name']), function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search['city_name']}%");
            })
            ->paginate(config('basic.paginate'));

        $cityList =  $cityList->appends($search);

        return view('admin.country.cityList', compact('cityList'));
    }

}
