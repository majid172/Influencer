<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Level;
use App\Models\Listing;
use App\Models\ListingFee;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\List_;

class AdminListingController extends Controller
{
	public function list()
	{
		$data['lists'] = Listing::with('extraImages', 'category', 'subCategory', 'user')
							->whereHas('user',function($query){
								$query->where('status',1);
							})
							->paginate(config('basic.paginate'));
		$data['categories'] = Category::get();
		$data['subcategories'] = SubCategory::get();
	
		return view('admin.listing.list',$data);
	}

	public function listSearch(Request $request)
	{
		$search = $request->all();
		$data['categories'] = Category::get();
		$data['subcategories'] = SubCategory::get();
		$data['lists'] = Listing::when(isset($search['title']), function($query) use($search){
							return $query->where('title','LIKE',"%{$search['title']}%");
							})
							->when(isset($search['category']),function($query) use($search){
								return $query->where('category_id',$search['category']);
							})
							->when(isset($search['subcategory']),function($query) use($search){
								return $query->where('sub_category_id',$search['subcategory']);
							})
							->when(isset($search['status']),function($query) use ($search){
								return $query->where('status',$search['status']);
							})
							
							->paginate(config('basic.paginate'));
		return view('admin.listing.list',$data);
		
	}
	public function approve(Request $request, $id=null)
	{
		$list = Listing::where('id',$id)->firstOrFail();
		$list->status = ($list->status == 0) ? 1:0;
		$list->save();
		return redirect()->back()->with('success','Aciton change successfully.');
	}

	public function cancel($id=null)
	{
		$list = Listing::where('id',$id)->firstOrFail();

		if($list->status == 2)
		{
			return redirect()->back()->with('error','Already cancel this listing.');
		}
		elseif(($list->status == 1) || ($list->status == 0)){
			$list->status = 2;
		}
		$list->save();
		return redirect()->back()->with('success','Successfully cancel this listing.');
	}

	public function serviceFee()
	{
		$data['levels'] = Level::with('details')->get();
		$data['fees'] = ListingFee::with('levels.details')->get();

		return view('admin.listing.service_fee',$data);
	}
	public function serviceStatus(Request $request,$id)
	{
	
		$listing_fee = ListingFee::findOrFail($id);
		$listing_fee->status = ($listing_fee->status == 1) ? 0 : 1;
		$listing_fee->save();
		return back()->with('success','Status change successfully.');
	}

	public function feeStore(Request $request)
	{
		$levelGenerate = $request->levelGenerate;
		$level  =$request->level;
		$percentage = $request->percentage;

		for ($i=0;$i<$levelGenerate;$i++)
		{
			$services = new ListingFee();
			$services->level_id = $level[$i];
			$services->percentage = $percentage[$i];
			$services->save();
		}
		return back()->with('success','Successfully stored service charged');

	}

	public function feeUpdate(Request $request)
	{
		$request->validate([
			'level_id' => 'required|integer',
			'percentage' => 'required|integer'
		]);

		$fee = ListingFee::findOrFail($request->id);
		$fee->level_id = $request->level_id;
		$fee->percentage = $request->percentage;
		$fee->save();
		return back()->with('success','Service fee updated successfully.');

	}


}
