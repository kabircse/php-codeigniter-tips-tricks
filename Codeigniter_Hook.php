// Codeigniter Hook

//Simply enable hooks:

$config['enable_hooks'] = TRUE;

//And then define your hook:

 $hook['post_controller_constructor'] = array(
                                'class'    => 'Hooks',
                                'function' => 'session_check',
                                'filename' => 'hooks.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                ); 

//Then use it in your class:


    class Hooks {
        var $CI;

        function Hooks() {
            $this->CI =& get_instance();
        }

        function session_check() {
            if(!$this->CI->session->userdata("logged_in") && $this->CI->uri->uri_string != "/user/login")
                redirect('user/login', 'location');
        }
    }
