<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credentials = request([ 'page', 'sortBy', 'sortDesc']);
        
        $orderBy = $credentials['sortBy'];
        $sortDesc = (bool) $credentials['sortDesc'] ? 'asc' : 'desc';
        
        $users = User::where('id', '!=', auth()->user()->id)
            ->orderBy($orderBy, $sortDesc)
            ->paginate(10);

        foreach ($users as $user) {
            
            $user->getRoleNames();
            
        }
        
        return response()->json([
            'success' => true,
            'users' => $users,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        
        //$role = Role::where('id', (int) $input['role']);
        $user->assignRole($role);

        if($user){
            return response()->json([
                'success' => true,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->getRoleNames()[0];
        
        return response()->json([
            'success' => true,
            'users' => $user
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $res = $user->delete();
        
        if($res){
            return response()->json([
                'success' => true,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
        ], Response::HTTP_OK);
        
    }

    public function checkEmailUniqueness()
    {
        $credentials = request(['email']);
        $email = $this->sanitizeEmail($credentials['email']);
       
        if($email){
            $res = User::where('email', $email)->first();
            if($res){
                return response()->json([
                    'success' => true,
                ], Response::HTTP_OK);
            }
        }

        return response()->json([
            'success' => false,
        ], Response::HTTP_OK);
    }

    public function sanitizeEmail($email)
    {
        $filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        
        if ($filteredEmail) {
            return filter_var($filteredEmail, FILTER_SANITIZE_EMAIL);
        }

        return null;
    }
}
