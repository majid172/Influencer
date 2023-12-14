<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\CategoryDetails;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function categoryList()
	{
		$allCategory = Category::with('details')->latest()->get();
		return view('admin.category.categoryList', compact('allCategory'));
	}


	public function categoryCreate()
	{
		$languages = Language::all();
		return view('admin.category.categoryCreate', compact('languages'));
	}


	public function categoryStore(Request $request, $language)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'name.*' => 'required|max:20',
		];

		$message = [
			'name.*.required' => 'Category Name field is required',
			'name.*.max' => 'Category Name field may not be greater than :max characters.',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$category = new Category();
		if ($request->has('status')) {
			$category->status = $request->status;
		}
		$category->save();

		$category->details()->create([
			'language_id' => $language,
			'name'        => $purifiedData["name"][$language],
		]);

		return redirect()->route('admin.category.index')->with('success', 'Category Successfully Saved');
	}


	public function categoryEdit($id){
		$languages = Language::all();
		$categoryDetails = CategoryDetails::with('category')->where('category_id', $id)->get()->groupBy('language_id');

		return view('admin.category.categoryEdit', compact('languages', 'categoryDetails', 'id'));
	}


	public function categoryUpdate(Request $request, $id, $language_id){

		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'name.*' => 'required|max:100',
		];

		$message = [
			'name.*.required' => 'Category Name field is required',
			'name.*.max' => 'Category Name field may not be greater than :max characters.',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$category = Category::findOrFail($id);
		if ($request->has('status')) {
			$category->status = $request->status;
		}
		$category->save();

		$category->details()->updateOrCreate([
			'language_id' => $language_id
		],
			[
				'name' => $purifiedData["name"][$language_id],
			]
		);

		return redirect()->route('admin.category.index')->with('success', 'Category Successfully Updated');
	}


	public function categoryDelete($id){
		$categoryDelete = Category::findOrFail($id);
		$categoryDelete->delete();

		$subCategoryDelete = SubCategory::where('category_id',$id)->get();
		if ($subCategoryDelete) {
			foreach ($subCategoryDelete as $key => $subCate) {
				$relatedsubCategoryToDelete = SubCategory::where('id', $subCate->id)->firstOrFail();
				if ($relatedsubCategoryToDelete) {
					$relatedsubCategoryToDelete->delete();
				}
			}
		}

		return back()->with('success', 'Category has been deleted');
	}

}
