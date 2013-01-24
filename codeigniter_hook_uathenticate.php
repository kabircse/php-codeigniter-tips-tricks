#application/hooks/SecureAccount.php
class SecureAccount
{
    var $obj;

    //--------------------------------------------------
    //SecureAccount constructor
    function SecureAccount()
    {
        $this->obj =& get_instance();
    }

    //--------------------------------------------------
    //Redirect to https if in the account area without it
    function index()
    {
        if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== 'on')
        {
            $this->obj =& get_instance();
            $this->obj->load->helper(array('url', 'http'));

            $current = current_url();
            $current = parse_url($current);

            if((stripos($current['path'], "/account/") !== false))
            {
                $current['scheme'] = 'https';

                redirect(http_build_url('', $current), 'refresh');
            }
        }
    }
}

#application/config/hooks.php

/* Force HTTPS for account area */
$hook['post_controller_constructor'] = array(
                                'class'    => 'SecureAccount',
                                'function' => 'index',
                                'filename' => 'SecureAccount.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );