<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Language;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategoryDetails;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class SubCategoryController extends Controller
{
	public function subCategoryList()
	{
		$data['subCategoryList'] = SubCategory::with('details', 'category.details')->latest()->get();
		return view('admin.subCategory.subCategoryList', $data);
	}


	public function subCategoryCreate()
	{
		$languages = Language::all();
		$data['category'] = Category::with('details')->get();

		return view('admin.subCategory.subCategoryCreate',$data, compact('languages'));
	}


	public function subCategoryStore(Request $request, $language=null)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'category_id' => 'required',
			'name.*'    => 'required|max:35',
		];
		$message = [
			'category_id.required'   => 'Please Select a Category',
			'name.*.max'           => 'Sub-Category Name field may not be greater than :max characters',
			'name.*.required'      => 'Sub-Category Name field is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$subCategoery = new SubCategory();
		$subCategoery->category_id = $request->category_id;
		if ($request->has('status')) {
			$subCategoery->status = $request->status;
		}
		$subCategoery->save();

		$subCategoery->details()->create([
			'language_id' => $language,
			'name'        => $purifiedData["name"][$language],
		]);

		return redirect()->route('admin.subCategory.index')->with('success', 'Sub-Categoery Successfully Saved');
	}


	public function subCategoryEdit($id){
		$languages           = Language::all();
		$SubCategoryDetails = SubCategoryDetails::with('subCategory')->where('sub_category_id', $id)->get()->groupBy('language_id');
		$category = Category::with('details')->get();
		return view('admin.subCategory.subCategoryEdit', compact('languages', 'SubCategoryDetails', 'category', 'id'));
	}


	public function subCategoryUpdate(Request $request, $id, $language_id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'category_id' => 'sometimes|required',
			'name.*'    => 'required|max:35',
		];
		$message = [
			'category_id.required'   => 'Please Select a Category',
			'name.*.max'           => 'Sub-Category Name field may not be greater than :max characters',
			'name.*.required'      => 'Sub-Category Name field is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$subCategoery = SubCategory::findOrFail($id);

		if($request->has('category_id')){
			$subCategoery->category_id = $request->category_id;
		}
		if ($request->has('status')) {
			$subCategoery->status = $request->status;
		}

		$subCategoery->save();

		$subCategoery->details()->updateOrCreate([
			'language_id'   => $language_id
		],
			[
				'name' => $purifiedData["name"][$language_id],
			]
		);

		return redirect()->route('admin.subCategory.index')->with('success', 'Sub-Category Successfully Updated');
	}


	public function subCategoryDelete($id)
	{
		$subCategoery = SubCategory::findOrFail($id);

		$subCategoery->delete();

		return back()->with('success', 'Sub-Categoery has been deleted');
	}


}
