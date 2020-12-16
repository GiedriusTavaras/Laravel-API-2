<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Email;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //nereikia
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
            'name' => ['required', 'alpha', 'min:3', 'max:20'],
            'last_name' => ['required', 'alpha', 'min:3', 'max:20'],
            'address' => ['required', 'min:5', 'max:50'],
            'password' => ['required', 'alpha_num:users,password', 'min:5', 'unique:users,password', 'max:20'],
            'email' => ['email', 'unique:emails,email']
        ]);
        
        $user = User::create($request -> all());
        
        if ($request->input('email')) {
            Email::create([
                'email' => request('email'),
                'user_id' => $user->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with('emails')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // nereikia
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
        $request->validate([
            'name' => ['alpha', 'min:3', 'max:20'],
            'last_name' => ['alpha', 'min:3', 'max:20'],
            'address' => ['min:5', 'max:50'],
            'password' => ['alpha_num:users,password', 'min:5', 'unique:users,password', 'max:20'],
            'email' => ['email', 'unique:emails,email']
        ]);

        User::with('emails')->find($id)->update($request -> all());

        if ($request->input('email')) {
            Email::where('user_id', $id)->update(array('email' => request('email')));
        }
        
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }
}
