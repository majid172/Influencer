<?php

namespace App\Http\Controllers;

use App\Models\PayoutMethod;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PayoutMethodController extends Controller
{
	use Upload;

	public function addMethod(Request $request)
	{
		if ($request->isMethod('get')) {
			return view('admin.payoutMethod.create');
		} elseif ($request->isMethod('post')) {

			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'methodName' => 'required|min:3|max:50|unique:payout_methods',
				'description' => 'required|min:3|max:50',
				'min_limit' => 'required|numeric|not_in:0',
				'max_limit' => 'required|numeric|not_in:0',
				'percentage_charge' => 'required|numeric|not_in:0',
				'fixed_charge' => 'required|numeric|not_in:0',
				'fieldName.*' => 'required|string|min:3',
				'fieldType.*' => 'required|string|min:3',
				'fieldValidation.*' => 'required|string|min:3',
				'is_active' => 'nullable|integer|min:0|in:0,1',
			], [
				'min' => 'This field must be at least :min characters.',
				'string' => 'This field must be :string.',
				'required' => 'This field is required.',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;

			$inputForm = [];
			if (isset($purifiedData->fieldType)) {
				$inputs = [];
				for ($i = 0; $i < count($purifiedData->fieldType); $i++) {
					$inputs['name'] = strtolower(Str::snake($purifiedData->fieldName[$i]));
					$inputs['label'] = $purifiedData->fieldName[$i];
					$inputs['type'] = $purifiedData->fieldType[$i];
					$inputs['validation'] = $purifiedData->fieldValidation[$i];
					$inputForm[$inputs['name']] = $inputs;
				}
			}

			$payoutMethod = new PayoutMethod();
			$payoutMethod->methodName = $purifiedData->methodName;
			$payoutMethod->description = $purifiedData->description;
			$payoutMethod->min_limit = $purifiedData->min_limit;
			$payoutMethod->max_limit = $purifiedData->max_limit;
			$payoutMethod->percentage_charge = $purifiedData->percentage_charge;
			$payoutMethod->fixed_charge = $purifiedData->fixed_charge;
			$payoutMethod->is_active = $purifiedData->is_active;
			$payoutMethod->inputForm = (empty($inputForm)) ? null : json_encode($inputForm);

			if ($request->file('logo') && $request->file('logo')->isValid()) {
				$extension = $request->logo->extension();
				$logoName = strtolower($purifiedData->methodName . '.' . $extension);

				$image = $this->fileUpload($request->logo, config('location.methodLogo.path'), null, $logoName);
				if ($image) {
					$payoutMethod->logo = $image['path'];
					$payoutMethod->driver = $image['driver'];
				}
			}
			$payoutMethod->save();
			return redirect(route('payout.method.list'))->with('success', 'Method Successfully Saved');
		}
	}

	public function index()
	{
		$payoutMethods = PayoutMethod::latest()->paginate(config('basic.paginate'));

		return view('admin.payoutMethod.index', compact('payoutMethods'));
	}

	public function edit(Request $request, PayoutMethod $payoutMethod)
	{
		if ($request->isMethod('get')) {
			return view('admin.payoutMethod.edit', compact('payoutMethod'));
		} elseif ($request->isMethod('put')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'methodName' => 'required|min:3|max:50|unique:payout_methods,methodName,' . $payoutMethod->id,
				'description' => 'required|min:3|max:50',
				'min_limit' => 'required|numeric|not_in:0',
				'max_limit' => 'required|numeric|not_in:0',
				'percentage_charge' => 'required|numeric|not_in:0',
				'fixed_charge' => 'required|numeric|not_in:0',
				'fieldName.*' => 'required|string|min:3',
				'fieldType.*' => 'required|string|min:3',
				'fieldValidation.*' => 'required|string|min:3',
				'is_active' => 'nullable|integer|min:0|in:0,1',
			], [
				'min' => 'This field must be at least :min characters.',
				'string' => 'This field must be :string.',
				'required' => 'This field is required.',
			]);


			$purifiedData = (object)$purifiedData;

			$inputForm = [];
			if (isset($purifiedData->fieldType)) {
				$inputs = [];
				for ($i = 0; $i < count($purifiedData->fieldType); $i++) {
					$inputs['name'] = strtolower(Str::snake($purifiedData->fieldName[$i]));
					$inputs['label'] = $purifiedData->fieldName[$i];
					$inputs['type'] = $purifiedData->fieldType[$i];
					$inputs['validation'] = $purifiedData->fieldValidation[$i];
					$inputForm[$inputs['name']] = $inputs;
				}
			}

			$parameters = [];
			if ($payoutMethod->parameters) {
				foreach ($request->except('_token', '_method', 'image') as $k => $v) {
					foreach ($payoutMethod->parameters as $key => $cus) {
						if ($k != $key) {
							continue;
						} else {
							$rules[$key] = 'required|max:191';
							$parameters[$key] = $v;
						}
					}
				}
			}

			$supported_params = [];
			if ($request->has('supported_currency')) {
				foreach ($request->supported_currency as $k => $v) {
					$supported_params[$v] = $v;
				}
			}

			$collectionSpecification = collect($request->rate);
			$rate_params = [];
			if ($payoutMethod->supported_currency) {
				foreach ($collectionSpecification as $k => $v) {
					foreach ($payoutMethod->supported_currency as $key => $cus) {
						if ($k != $key) {
							continue;
						} else {
							if ($v == null) {
								$v = 1.00;
							}
							$rate_params[$key] = $v;
						}
					}
				}
			}

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$payoutMethod->methodName = $purifiedData->methodName;
			$payoutMethod->banks = @$purifiedData->banks;
			$payoutMethod->parameters = @$parameters;
			$payoutMethod->description = $purifiedData->description;
			$payoutMethod->min_limit = $purifiedData->min_limit;
			$payoutMethod->max_limit = $purifiedData->max_limit;
			$payoutMethod->percentage_charge = $purifiedData->percentage_charge;
			$payoutMethod->fixed_charge = $purifiedData->fixed_charge;
			$payoutMethod->supported_currency = $supported_params;
			$payoutMethod->convert_rate = $rate_params;
			$payoutMethod->is_active = $purifiedData->is_active;
			$payoutMethod->is_auto_update = @$purifiedData->is_auto_update;
			$payoutMethod->environment = @$purifiedData->environment;
			if ($payoutMethod->is_automatic == 0) {
				$payoutMethod->inputForm = (empty($inputForm)) ? null : json_encode($inputForm);
			}

			if ($request->file('logo') && $request->file('logo')->isValid()) {
				$extension = $request->logo->extension();
				$logoName = strtolower($purifiedData->methodName . '.' . $extension);
				$old = $payoutMethod->logo;
				$image = $this->fileUpload($request->logo, config('location.methodLogo.path'), $payoutMethod->driver, null, $old);
				if ($image) {
					$payoutMethod->logo = $image['path'];
					$payoutMethod->driver = $image['driver'];
				}
			}

			$payoutMethod->save();

			return redirect(route('payout.method.list'))->with('success', 'Method Successfully Saved');
		}
	}
}
