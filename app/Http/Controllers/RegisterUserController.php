<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserPostRequest;
use App\Http\Requests\ExistingUserUpdateRequest;

class RegisterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register');
    }

    private function imageUpload($image)
    {
    	$imageName = date('YmdHi').'_'.uniqid().'_'.$image->getClientOriginalName();
    	$directory = 'uploads/';
    	$image->move($directory, $imageName);	
    	return $imageName;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterUserPostRequest $request)
    {
        $user                = new User();
        $user->name          = $request->name;
        $user->father_name   = $request->father_name;
        $user->email         = $request->email;
        $user->profile_image = $this->imageUpload($request->file('profile_image'));
        $user->password      = Hash::make($request->password);
        $user->save();

        $this->guard()->login($user);

        return redirect()->route('home');
    }


    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Show the form for editing the specified resource.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExistingUserUpdateRequest $request, $id)
    {
        $user               = User::findOrFail($id);
        $user->name         = $request->name;
        $user->father_name  = $request->father_name;
        $user->email    = $request->email;
        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');
            @unlink(public_path('uploads/').$user->profile_image);
            $fileName = date('YmdHi').'_'.uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/'), $fileName);
            $user->profile_image = $fileName;
        }
        $user->save();

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!is_null($id)) {
            $user = User::findOrFail($id);
            if (file_exists(public_path('/uploads/') . $user->profile_image) AND ! empty($user->profile_image)) {
                @unlink(public_path('/uploads/') . $user->profile_image);
            }
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User Deleted Successfully !!!');
        }
    }
}
