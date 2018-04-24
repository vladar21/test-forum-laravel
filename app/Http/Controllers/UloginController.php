<?php
/**
 * Ulogin.ru auto registration or login.
 */
namespace App\Http\Controllers;

use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Redirect;

class UloginController extends Controller
{

// Login user through social network.
    public function login(Request $request)
    {
        // Get information about user.
        $data = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
        $user = json_decode($data, TRUE);

        $network = $user['network'];

        // Find user in DB.
        $userData = User::where('email', $user['email'])->first();

        // Check exist user.
        if (isset($userData->id)) {

            // Check user status.
            // if ($userData->status) {

                // Make login user.
                Auth::loginUsingId($userData->id, TRUE);
            // }
            // Wrong status.
            // else {
            //     \Session::flash('flash_message_error', trans('interface.AccountNotActive'));
            // }

            return Redirect::back();
        }
        // Make registration new user.
        else {

            // Create new user in DB.
            $newUser = User::create([
                
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                
                'email' => $user['email'],
                'password' => Hash::make(str_random(8))
                
            ]);

            // Make login user.
            Auth::loginUsingId($newUser->id, TRUE);

            \Session::flash('flash_message', trans('interface.ActivatedSuccess'));

            return Redirect::back();
        }
    }
}