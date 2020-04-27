<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\StorageResource;
use Illuminate\Support\Facades\Auth;
use App\Storage;

class StorageController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    
    public function index() {
        $storages = StorageResource::collection(Storage::all());
        return response()->json(['success' => true, 'data' => $storages]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'product_name' => 'required',
            'product_description' => 'required',
            'product_qty' => 'required'
        ]);
        $storage = new Storage;
        $storage->product_name = $request->product_name;
        $storage->product_description = $request->product_description;
        $storage->product_qty = $request->product_qty;
        $storage->user_id = Auth::user()->id;
        $storage->save();

        $storage = new StorageResource($storage);
        return response()->json(['success' => true, 'data' => $storage]);
    }

    public function update(Request $request, Storage $storage) {
        $storage->update($request->only(['product_name', 'product_description', 'product_qty']));
        $storage = new StorageResource($storage);
        return response()->json(['success' => true, 'data' => $storage]);
    }

    public function show(Storage $storage) {
        $storage = new StorageResource($storage);
        return response()->json(['success' => true, 'data' => $storage]);
    }

    public function destroy(Request $request, Storage $storage) {
        $storage->delete();
        return response()->json(['success' => true, 'data' => "Successfully Delete Product"]);
    }
}
