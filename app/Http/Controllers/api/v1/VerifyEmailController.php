<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\VerifyEmailResponse;

class VerifyEmailController extends Controller
{
    //
    public function __invoke(Request $request ,$id,$hash){

        $user=User::findOrFail($id);

        if($request->hasValidSignature()) {
            return app(VerifyEmailResponse::class);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'message' => 'Email verified successfully'
        ]);

    }
}
