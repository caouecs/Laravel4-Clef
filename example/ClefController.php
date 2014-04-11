<?php

class ClefController extends BaseController
{

    /**
     * Authentication with Clef account
     *
     * @return Response
     */
    public function authentication()
    {
        $response = \Aperdia\Clef::authentication($_GET['code']);

        // error
        if ($response == false) {
            $error = 'Error';
        // error
        } elseif (isset($response['error'])) {
            $error = $response['error'];
        // success
        } elseif (isset($response['success'])) {
            // verif if exists account in Authentication table
            $verif = Authentication::whereprovider("clef")->whereprovider_uid($response['info']['id'])->first();

            // no account
            if ($verif == null) {


            // Find account
            } else {

                // Find the user using the user id
                $user = User::find($verif->user_id);

                // RAZ logout
                if ($user->logout == 1) {
                    $user->logout = 0;
                    $user->save();
                }

                // Log the user in
                Auth::login($user);

                return Redirect::intended('/');
            }
        // error
        } else {
            $error = 'Unknown error';
        }

        return Redirect::to("login")
            ->withErrors($error);
    }

    /**
     * Logout by WebHook
     *
     * @access public
     * @return Response
     */
    public function logout()
    {
        // Token from Clef.io
        if (isset($_POST['logout_token'])) {

            // Verif token
            $clef = \Aperdia\Clef::logout($_POST['logout_token']);

            if ($clef != false) {
                // Verif in Authentication table
                $auth = Authentication::whereprovider("clef")->whereprovider_uid($clef)->first();

                if ($auth != null) {
                    $user = User::find($auth->user_id);

                    if ($user != null) {
                        $user->logout = 1;
                        $user->save();
                    }
                }
            }
        }
    }
}
