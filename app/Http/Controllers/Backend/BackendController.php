<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'], ['except' => ['login']]);
    }
     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        //$header = $request->header('Authorization');
        $credentials = request(['email']);
        $email = $credentials['email'];

        $user=User::where('email',$email )->first();
        
        $session = DB::table('sessions')->where('user_id', $user->id )->first();
       
        if($session){
            $role = $user->getRoleNames()[0];
            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token, $role);
        }
        
        return $this->inauthorizedResponse();
        
    }

    public function checkToken()
    {
        return response()->json(['success' => true], Response::HTTP_OK);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function inauthorizedResponse()
    {
        return response()->json(['error' => 'Unauthorized'],  Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $role)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'role' => $role,
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
