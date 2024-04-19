<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{

 /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
       
        // Validate the incoming data
        $request->validate([
            'name' =>'required|string',
            'email' =>'required|email|unique:users',
            'password' => 'required|confirmed',
            'role_id' =>'required|integer',
        ]);

        // Create a new user record in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);
if($user->save()){
    return response()->json([
        'user' => $user,
        'message' => 'User created successfully'
    ], 201);
}else{
    return response()->json([
       'message' => 'Something went wrong'
    ], 500);
}
        // Return a JSON response indicating successful user creation

    }

    /**
     * Authenticate a user with the provided credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        
        $credentials = request(['email', 'password']);

        
        if (! $token = auth()->attempt($credentials)) {
           
            return response()->json(['error' => 'Unauthorized'], 401);
        }

       
        return $this->respondWithToken($token);
    }

    /**
     * Log out the currently authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
       
        auth()->logout();

        
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Return the profile of the currently authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(){
       
        return response()->json(auth()->user());
    }

    /**
     * Refresh the authentication token of the currently authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(){
       
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
