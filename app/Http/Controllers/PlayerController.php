<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
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


    public function show()
    {
        return response()->json(Player::all());
    }

    public function showByName(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $filterData = Player::where('name','LIKE','%'.$request->input('name').'%')->get();

        return response()->json(['status' => 'success', 'data' => $filterData], 200);
    }
    
    public function showPlayerProducts(Request $request){
        $user = Player::findOrFail($request->input('id'));
        $products = Player::find($request->input('id'))->products;

        return response()->json(['status' => 'success', 'user' => $user, 'products' => $products], 200);
    }
}
