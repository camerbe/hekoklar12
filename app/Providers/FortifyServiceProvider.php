<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\FailedPasswordResetResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\PasswordResetResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // LOGIN RESPONSE
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = auth()->user();

                    return response()->json([
                        'success'=>true,
                        'user' => $user,
                        'token' => $user->createToken('api-token')->plainTextToken,
                        'message' => 'Login successful',
                    ],Response::HTTP_OK);
                }
            };
        });
        // REGISTER RESPONSE
        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    return response()->json([
                        'success'=>true,
                        'user' => auth()->user(),
                        'message' => 'User registered successfully',
                    ], Response::HTTP_CREATED);
                }
            };
        });
        // LOGOUT RESPONSE
        $this->app->singleton(LogoutResponse::class, function () {
            return new class implements LogoutResponse {
                public function toResponse($request)
                {
                    $request->user()->currentAccessToken()->delete();

                    return response()->json([
                        'message' => 'Logged out successfully'
                    ]);
                }
            };
        });
        // EMAIL VERIFIED
        $this->app->singleton(VerifyEmailResponse::class, function () {
            return new class implements VerifyEmailResponse {
                public function toResponse($request)
                {
                    return response()->json([
                        'message' => 'Email verified successfully'
                    ]);
                }
            };
        });
        // PASSWORD RESET SUCCESS
        $this->app->singleton(PasswordResetResponse::class, function () {
            return new class implements PasswordResetResponse {
                public function toResponse($request)
                {
                    return response()->json([
                        'message' => 'Password reset successfully'
                    ]);
                }
            };
        });
        // PASSWORD RESET FAILED
        $this->app->singleton(FailedPasswordResetResponse::class, function () {
            return new class implements FailedPasswordResetResponse {
                public function toResponse($request)
                {
                    return response()->json([
                        'message' => 'Password reset failed'
                    ], 422);
                }
            };
        });
    }
}
