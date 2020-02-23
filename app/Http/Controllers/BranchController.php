<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\BranchItem;
use App\Models\Item;
use Validator;

class BranchController extends Controller
{
	public function index(Request $request){
		$branchInfo = Branch::with('items.itemInfo', 'transactions')
						->where('id', $request->id)->first();
		return response()->json([
			'branchInfo' => $branchInfo
		]);
	}

    public function show(Request $request){
    	$branches = Branch::get();

    	return response()->json([
    		'branches' => $branches,
    		'action' => 'get-branches'
    	]);
    }

    public function create(Request $request){
    	$validator = Validator::make($request->all(), [
    					'address' => 'required'
    				]);
    	if($validator->fails()){
    		return response()->json([
    			'errors' => $validator->messages()
    		]);
    	}

    	$branch = new Branch();
    	$branch->name = $request->address;
    	$branch->information = (object)[];
    	$branch->save();

    	$items = Item::get();
    	foreach($items as $item){
    		$branchItem = new BranchItem();
    		$branchItem->branch_id = $branch->id;
    		$branchItem->item_id = $item->id;
    		$branchItem->information = (object)[];
    		$branchItem->save();
    	}

    	return response()->json([
    		'action' => 'create-branch',
    		'branch' => $branch
    	]);
    }

    public function update(Request $request){
    	$validator = Validator::make($request->all(), [
    					'id' => 'required|numeric|exists:branches,id',
    					'address' => 'required'
    				]);
    	if($validator->fails()){
    		return response()->json([
    			'errors' => $validator->messages()
    		]);
    	}

    	$branch = Branch::where('id', $request->id)->first();
    	$branch->name = $request->address;
    	$branch->information = (object)[];
    	$branch->save();

    	return response()->json([
    		'action' => 'update-branch',
    		'branch' => $branch
    	]);
    }
}
