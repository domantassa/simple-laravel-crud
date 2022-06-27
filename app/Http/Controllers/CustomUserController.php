<?php

namespace App\Http\Controllers;

use App\Models\CustomUser;
use App\Models\UserDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return CustomUser::with(['user_details:id,address,id,user_id'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $custom_user = CustomUser::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'email' => $request->email
        ]);

        if($request->address != null) {
            UserDetails::create([
                'address' => $request->address,
                'user_id' => $custom_user->id,
            ]);
        }

        return $custom_user;
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
        $custom_user = CustomUser::find($id);
        $user_details = $custom_user->user_details;

        $custom_user->update($request->all());

        if($request->address != null) {
            if($user_details == null) {
                UserDetails::create([
                    'address' => $request->address,
                    'user_id' => $custom_user->id,
                ]);
            } else {
                $user_details->update(['address' => $request->address]);
            }
        }

        return $custom_user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $custom_user = CustomUser::find($id);
        $user_details = $custom_user->user_details;

        UserDetails::destroy($user_details->id);
        return CustomUser::destroy($custom_user->id);
    }
}
