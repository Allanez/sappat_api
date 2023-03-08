<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Player;
use App\Models\Barangay;
use App\Models\Municipality;

class PlayerController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::all();
        return view('players/index', ['players' => $players]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('players/new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        if($request->input('barangay_id') != -1){
            $barangay = Barangay::find($request->input('barangay_id'));
            $address = $barangay->name.", ".$barangay->municipality->name.", ".$barangay->municipality->province->name;
            $player = Player::create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'address' => $address,
                'description' => $request->input('description'),
                'vc_segment' => $request->input('vc_segment'),
                'barangay_id' => $request->input('barangay_id'),
                'municipality_id' => $request->input('municipality_id'),
                'data_source' => $request->input('data_source'),
            ]);
        }else{
            $municipality = Municipality::find($request->input('municipality_id'));
            $address = $municipality->name.", ".$municipality->province->name;
            $player = Player::create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'address' => $address,
                'description' => $request->input('description'),
                'vc_segment' => $request->input('vc_segment'),
                'barangay_id' => null,
                'municipality_id' => $request->input('municipality_id'),
                'data_source' => $request->input('data_source'),
            ]);
        }
        
        

        return redirect()->route('players.edit', ['player' => $player]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $player = Player::find($id);
        if($request->user()->cannot('view', $player)){
            abort(403, "You are unauthorized to view the details of this player.");
        }

        return view('players/show', ['player'=>$player]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $player = Player::find($id);
        if($request->user()->cannot('update', $player)){
            abort(403, "You are unauthorized to perform this action.");
        }
        return view('players/edit', ['player'=> $player]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $player = Player::find($id);

        $player = Player::find($id);
        if($request->user()->cannot('update', $player)){
            abort(403, "You are unauthorized to perform this action.");
        }
        
        if($request->input('barangay_id') != -1){
            $barangay = Barangay::find($request->input('barangay_id'));
            $address = $barangay->name.", ".$barangay->municipality->name.", ".$barangay->municipality->province->name;
            $player->update([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'address' => $address,
                'description' => $request->input('description'),
                'vc_segment' => $request->input('vc_segment'),
                'barangay_id' => $request->input('barangay_id'),
                'municipality_id' => $request->input('municipality_id'),
                'data_source' => $request->input('data_source'),
            ]);
        }else{
            $municipality = Municipality::find($request->input('municipality_id'));
            $address = $municipality->name.", ".$municipality->province->name;
            $player->update([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'address' => $address,
                'description' => $request->input('description'),
                'vc_segment' => $request->input('vc_segment'),
                'municipality_id' => $request->input('municipality_id'),
                'barangay_id' => null,
                'data_source' => $request->input('data_source'),
            ]);
        }
        return redirect()->route('players.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
