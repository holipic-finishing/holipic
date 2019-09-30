<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\API\BaseApiController;
use Illuminate\Support\Facades\URL;

class VerificationController extends BaseApiController
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        URL::forceScheme('https');
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    public function check(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->responseSuccess('Email Verified');
        } else {
            return $this->responseError('Email not verified');
        }
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        if (
            $request->route('id') == $request->user()->getKey() &&
            $request->user()->markEmailAsVerified()
        ) {
            event(new Verified($request->user()));
            return $this->responseSuccess('Email verified!');
        }
        return $this->responseError('Cannot verify email!');
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->responseError('User already have verified email!', null, 422);
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->responseSuccess('The notification has been resubmitted');
    }
}
