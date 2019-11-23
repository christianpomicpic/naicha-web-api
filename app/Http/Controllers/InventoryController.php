<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Validator;
use Auth;

class InventoryController extends Controller
{
    public function show(Request $request){
    	$items = Item::with('creator')->get();
    	return response()->json([
    		'items' => $items
    	]);
    }

    public function create(Request $request){
    	$validator = Validator::make($request->all(), [
    					'itemName' => 'required',
    					'units' => 'required|array|min:1'
    				 ]);

   		if($validator->fails()){
			return response()->json([
				'errors' => $validator->messages()
			], 422);
   		}

   		$newItem = new Item();
   		$newItem->name = $request->itemName;
   		$newItem->information = [ 'units' => $request->units ];
   		$newItem->user_id = Auth::user()->id;
   		$newItem->save();

   		$itemInfo = Item::with('creator')->where('id', $newItem->id)->first();

   		return response()->json([
   			'item' => $itemInfo
   		]);
    }

    public function update(Request $request){
    	$validator = Validator::make($request->all(), [
    					'id' => 'required|numeric|exists:items',
    					'itemName' => 'required',
    					'units' => 'required|array|min:1'
    				 ]);

    	if($validator->fails()){
			return response()->json([
				'errors' => $validator->messages()
			], 422);
   		}

   		$itemInfo = Item::with('creator')->where('id', $request->id)->first();
   		$itemInfo->name = $request->itemName;
   		$itemInfo->information = [ 'units' => $request->units ];
   		$itemInfo->save();

   		return response()->json([
   			'item' => $itemInfo
   		]);
    }
}
