<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Country;

use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( ! auth()->user()->is_admin()) {
            abort(404,"Your not admin");
        }
        $users = User::latest()->paginate(15);
        $countries  = Country::all();
        return view('Users.index',compact('users','countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data = $request->validate([

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required','integer'],
            'country' => ['required', 'string',],
            'username' => ['required', 'string', 'max:255', 'unique:users'],

        ]);
        $user =  User::create([
            'email' => $data['email'],
            'country' => $data['country'],
            'username' => $data['username'],
            'role_id' => $data['role'],
            'password' => Hash::make('password'), 
        ]);

        return redirect()->back()->with('success',"user created ") ;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return back();

    }
}
