<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show(){
        return response()->json(Product::all());
    }

    public function showByName(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $filterData = Product::where('common_name','LIKE','%'.$request->input('name').'%')->get();

        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }

    //
}
