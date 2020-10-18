<?php

namespace App\Http\Controllers\Api\Users;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\PasswordReset;
use Illuminate\Http\Request;

/**
 * Class ApiPasswordResetController
 */
class ApiPasswordResetController extends Controller
{

    /**
     * LoginController constructor
    */
    public function __construct() {
    }

    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        // constants
        $site_url = config('constants.site.url');
        $status_active = config('constants.status.active');

        // if no user with email exists
        if (!$user) {
            return response()->json([
                'message' => "A password reset link was sent to [" . $request->email . "] if it exists."
            ], 200);
        }

        $resetToken = str_random(60);
        /* $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => $resetToken,
                'status_id' => config('constants.status.active')
             ]
        ); */
        $passwordReset = PasswordReset::create(
            [
                'email' => $user->email,
                'token' => $resetToken,
                'status_id' => $status_active
             ]
        );

        if ($user && $passwordReset) {

            disableOtherPasswordResetsBySameUser($user->email, $passwordReset->id);

            // start send email to queue
            $resetUrl = $site_url . "/resetPassword/" . $resetToken;
            $subject = 'Reset Password';
            $title = $subject;
            $email_salutation = "Dear member,<br><br>";
            $email_text = "You are receiving this email because we received a password reset request for your account. <br>";
            $email_text .= "If you did not make this request, you can ignore this email. <br><br>";
            $email_text .= "To proceed, click on the link below or copy the link to a browser url: <br><br>";
            $email_text .= "<a href='$resetUrl'>$resetUrl</a> <br><br>";

            $panel_text = "";

            $email_footer = "Regards,<br>";
            $email_footer .= "SNB Management";

            //email queue
            $table_text = "";

            $parent_id = 0;
            $reminder_message_id = 0;
            $company_id = 0;
            $company_name = "";

            sendTheEmailToQueue($user->email, $subject, $title, $company_name, $email_text, $email_salutation,
            $company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);
            //end send email to queue

        }

        return response()->json([
            'message' => "A password reset link was sent to [" . $request->email . "] if it exists."
        ]);

    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        return response()->json($passwordReset);
    }

     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'message' => "We can't find a user with that e-mail address."
            ], 404);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        // $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }

}
