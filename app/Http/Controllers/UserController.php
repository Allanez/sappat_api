<?php

namespace App\Http\Controllers;

use App\Models\UserProjects;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function show()
    {
        return response()->json(User::all());
    }

    public function login(Request $request){

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if (isset($user)) {
            if (Hash::check($request->input('password'), $user->password)) {
                // $apikey = base64_encode(Str::random(40));
                // User::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;

                return response()->json(['status' => 'success', 'user_id' => $user->id], 200);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'Incorrect password!'], 401);
            }
        } else {
            return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
        }
    }
    
    // public function loginUsingFB(Request $request){
    //     try{
    //         $fb_user = Socialite::driver('facebook')->userFromToken($request->access_token);
    //     }catch( \Exception $e ){
    //         return response()->json(['status' => 'fail', 'message' => 'Access token is invalid!'], 401);
    //     }

    //     $user = User::where('facebook_id', $fb_user->id)->first();
    //     if(!$user){
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
        
    //     $apikey = base64_encode(Str::random(40));
    //     User::where('facebook_id', $fb_user->id)->update(['api_key' => "$apikey"]);
    //     return response()->json(['status' => 'success', 'user_id' => $user->id,'api_key' => $apikey], 200);
    // }

    // public function connectFacebookToUserAccount(Request $request){
    //     try{
    //         $fb_user = Socialite::driver('facebook')->userFromToken($request->access_token);
    //     }catch( \Exception $e ){
    //         return response()->json(['status' => 'fail', 'message' => 'Access token is invalid!'], 401);
    //     }

    //     $connected_user = User::where('facebook_id', $fb_user->id)->first();
    //     if($connected_user){
    //         return response()->json(['status' => 'fail', 'message' => 'Facebook account is already linked to another account!'], 401);
    //     }

    //     $user = User::where('id', $request->user()->id)->first();
    //     if($user){
    //         User::where('id', $request->user()->id)->update(['facebook_id' => "$fb_user->id"]);
    //         return response()->json(['status' => 'success'], 201);
    //     }else{
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    // }

    // public function register(Request $request){

    //     $this->validate($request, [
    //         'username' => 'required',
    //         'name' => 'required',
    //         'institution' => 'required',
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     $apikey = base64_encode(Str::random(40));

    //     $user = User::where('username', $request->input('username'))->first();

    //     if (isset($user)) {
    //         return response()->json(['status' => 'fail', 'message' => 'Username already exists!'], 401);
    //     } else {
    //         $user = User::create([
    //             'name' => $request->input('name'),
    //             'institution' => $request->input('institution'),
    //             'username' => $request->input('username'),
    //             'email' => $request->input('email'),
    //             'password' => Hash::make($request->input('password')),
    //             'userimage' => '/storage/default/profile-default.jpg'
    //         ]);
    
    //         return response()->json(['status' => 'success', 'message' => 'User successfully registered!', 'api_key' => $apikey, 'user_id' => $user->id], 200);
    //     }
    // }

    // public function update(Request $request){
        
    //     $this->validate($request, [
    //         'username' => 'required',
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if ($request->user()->cannot('update_a', User::class)) {
    //         // abort(403);
    //         return response()->json('Unauthorized.', 403);
    //     }

    //     $user = User::where('username', $request->input('username'))->first();

    //     if (isset($user)) {
    //         $user->username = $request->input('username');
    //         $user->email = $request->input('email');
    //         $user->password = Hash::make($request->input('password'));
    //         $user->save();

    //         return response()->json(['status' => 'success', 'message' => 'User updated successfully!'], 200);
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    // }

    // public function updateProfile(Request $request, $id){
        
    //     $this->validate($request, [
    //         'username' => 'required',
    //         'name' => 'required',
    //         'institution' => 'required',
    //         'email' => 'required',
    //     ]);

    //     echo($request->user());

    //     if ($request->user()->cannot('update_a', User::class)) {
    //         // abort(403);
    //         return response()->json('Unauthorized.', 403);
    //     }

    //     $user = User::where('id', $id)->first();

    //     if (isset($user)) {
    //         $user->username = $request['username'];
    //         $user->email = $request['email'];
    //         $user->name = $request['name'];
    //         $user->institution = $request['institution'];
    //         $user->bio = $request['bio'];
    //         $user->save();

    //         return response()->json(['status' => 'success', 'message' => 'User updated successfully!'], 200);
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    // }

    // public function delete(Request $request){
    //     $this->validate($request, [
    //         'username' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if ($request->user()->cannot('update_a', User::class)) {
    //         // abort(403);
    //         return response()->json('Unauthorized.', 403);
    //     }

    //     $user = User::where('username', $request->input('username'))->first();
    //     if (isset($user)) {
            
    //         if (Hash::check($request->input('password'), $user->password)) {
    //             $user->delete();

    //             return response()->json(['status' => 'success', 'message' => 'User deleted successfully!'], 200);
    //         } else {
    //             return response()->json(['status' => 'fail', 'message' => 'Unauthorized.'], 401);
    //         }
           
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    // }

    // public function getUserIDByUsername(Request $request){
    //     $this->validate($request, [
    //         'username' => 'required'
    //     ]);

    //     // if ($request->user()->cannot('update_a')) {
    //     //     // abort(403);
    //     //     return response()->json('Unauthorized.', 403);
    //     // }

    //     $user = User::where('username', $request->input('username'))->first();
    //     if (isset($user)) {
    //         return response()->json(['user_id' => $user->id], 201);
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'Username does not exist!'], 401);
    //     }
    // }

    // public function info($id){
    //     // return Auth::user();
    //     $user = User::where('id', $id)->first();
        
    //     return response()->json($user, 200);
    // }

    // public function checkPassword(Request $request, $id){
    //     $this->validate($request, [
    //         'password' => 'required'
    //     ]);
    
    //     $user = User::where('id', $id)->first();
    //     // echo($id);
    //     if (isset($user)) {
    //         if (Hash::check($request->input('password'), $user->password)) {
    //             return response()->json(['status' => 'success'], 200);
    //         } else {
    //             return response()->json(['status' => 'fail', 'message' => 'Incorrect password!'], 401);
    //         }
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'User does not exist!'], 401);
    //     }
    //     // return response($request->input('password'));
    // }

    // public function updatePassword(Request $request, $id){
    //     $this->validate($request, [
    //         'old_pw' => 'required',
    //         'new_pw' => 'required',
    //         'new_pw_confirm' => 'required'
    //     ]);
        
    //     if ($request->input('new_pw') == $request->input('new_pw_confirm')){
    //         $user = User::where('id', $id)->first();
    //         $user->password = Hash::make($request->input('new_pw'));
    //         $user->save();
    //         return response()->json(['status' => 'success'], 200);
    //     } else {
    //         return response()->json(['status' => 'fail', 'message' => 'New Password does not match!'], 401);
    //     }
        
    // }
}
