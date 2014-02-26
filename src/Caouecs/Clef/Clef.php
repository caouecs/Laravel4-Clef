<?php namespace Caouecs\Clef;

class Clef {

    /**
     * Clef base url
     *
     * @access protected
     */
    protected static $clef_base_url = 'https://clef.io/api/v1/';

    /**
     * Logout Webhook
     *
     * @access public
     * @param string $token
     * @return boolean | string If error (false) or clef_id from Clef.io
     */
    public static function logout($token)
    {
        // configuration
        $config = self::config();

        // no configuration file
        if ($config == false)
            return false;

        $url = self::$clef_base_url."logout";

        $postdata = http_build_query(array(
            'logout_token' => $token,
            'app_id'       => $config['app_id'],
            'app_secret'   => $config['app_secret']
        ));

        $opts = array('http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ));

        $context  = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if ($response != false) {
            $response = json_decode($response, true);

            if (isset($response['success']) && $response['success'] == true)
                return $response['clef_id'];
        }

        return false;
    }

    /**
     * Return authorization from Clef.io for an account
     *
     * @access public
     * @param string $code
     * @return boolean | array If error (false) or data from Clef.io
     */
    public static function authorize($code)
    {
        // configuration
        $config = self::config();

        // no configuration file
        if ($config == false)
            return false;

        $url = self::$clef_base_url."authorize";

        $postdata = http_build_query(array(
            'code'       => $code,
            'app_id'     => $config['app_id'],
            'app_secret' => $config['app_secret']
        ));

        $opts = array('http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ));

        // get oauth code for the handshake
        $context  = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if ($response) {
            $response = json_decode($response, true);

            return $response;
        }

        return false;
    }

    /**
     * Get info about member by access_token
     *
     * @access public
     * @param string $access_token
     * @return boolean | array If error (false) or data from Clef.io
     */
    public static function info($access_token)
    {
        $opts = array('http' => array(
            'method'  => 'GET'
        ));

        $url = self::$clef_base_url."info?access_token=".$authorize['access_token'];

        // exchange the oauth token for the user's info
        $context  = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if ($response != false) {
            $response = json_decode($response, true);

            return $response;
        }

        return false;
    }

    /**
     * Get authentication of a Clef account
     *
     * @access public
     * @param string $code
     * @return boolean | array If error (false) or data from Clef.io
     */
    public static function authentication($code = '')
    {
        if (empty($code))
            return false;

        // authorize
        $authorize = self::authorize($code);

        if ($authorize == false)
            return false;

        if (isset($authorize['error']))
            return $authorize;

        // return infos
        return self::info($authorize['access_token']);
    }

    /**
     * Display button for Login
     *
     * @access public
     * @param string $url Redirect url
     * @param array $params Params of button ( color and style )
     * @return string Script of button for login
     */
    public static function button($url, $params = array())
    {
        // configuration
        $config = self::config();

        // no configuration file
        if ($config == false)
            return null;

        // Params
        $color = (isset($params['color']) && $params['color'] == "white") ? "white" : "blue";
        $style = (isset($params['style']) && $params['style'] == "button") ? "button" : "flat";

        return '<script type="text/javascript" src="https://clef.io/v3/clef.js" class="clef-button" data-app-id="'.$config['app_id'].'" data-color="'.$color.'" data-style="'.$style.'" data-redirect-url="'. $url . '"></script>';
    }

    /**
     * Display custom button for Login
     *
     * @access public
     * @param string $title Title of link
     * @param string $url Redirect url
     * @param array $attributes Attributes of link
     * @return string Link of button for login
     */
    public static function customButton($title, $url, $attributes = array())
    {
        // configuration
        $config = self::config();

        // no configuration file
        if ($config == false)
            return null;

        $attributes = Helpers::addClass($attributes, "clef");

        return '<a href="https://clef.io/iframes/qr?app_id='.$config['app_id'].'&amp;redirect_url='.$url.'" '.\HTML::attributes($attributes).'>'.$title.'</a>';
    }

    /**
     * Configuration of Clef account
     *
     * @access protected
     * @return boolean | array False if not found, or Array with params
     */
    protected static function config()
    {
        // configuration
        $config = \Config::get("clef::clef");

        // no configuration file
        if (empty($config))
            return false;

        return $config;
    }
}
