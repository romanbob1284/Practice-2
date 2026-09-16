<?php

namespace App\Http\Controllers; 

class AdminControllerApi extends Controller
{

    
    public function __invoke()
    {
        $user = auth()->user();
        return response()->json([
            'message' => 'Admin panel',
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            ]);
    }
}