if( ! function_exists('secure_site_url') )
{
    function secure_site_url($uri = '')
    {
        $CI =& get_instance();
        return $CI->config->secure_site_url($uri);
    }
}
 
if( ! function_exists('secure_base_url') )
{
    function secure_base_url()
    {
        $CI =& get_instance();
        return $CI->config->slash_item('secure_base_url');
    }
}
 
if ( ! function_exists('secure_anchor'))
{
    function secure_anchor($uri = '', $title = '', $attributes = '')
    {
        $title = (string) $title;
 
        if ( ! is_array($uri))
        {
            $secure_site_url = ( ! preg_match('!^\w+://! i', $uri)) ? secure_site_url($uri) : $uri;
        }
        else
        {
            $secure_site_url = secure_site_url($uri);
        }
 
        if ($title == '')
        {
            $title = $secure_site_url;
        }
 
        if ($attributes != '')
        {
            $attributes = _parse_attributes($attributes);
        }
 
        return '<a href="'.$secure_site_url.'" ' . $attributes . '>'.$title.'</a>';
    }
}
 
if ( ! function_exists('secure_redirect'))
{
    function secure_redirect($uri = '', $method = 'location', $http_response_code = 302)
    {
        switch($method)
        {
            case 'refresh'    : header("Refresh:0;url=".secure_site_url($uri));
                break;
            default            : header("Location: ".secure_site_url($uri), TRUE, $http_response_code);
                break;
        }
        exit;
    }
}

if ( ! function_exists('redirect_external'))
{
     function redirect_external($uri = '', $method = 'location', $http_response_code = 302)
     {
          switch($method)
          {
               case 'refresh' :     header("Refresh:0;url=".prep_url($uri));
                                        break;
               default :    header("Location: ".prep_url($uri), TRUE, $http_response_code);
                              break;
          }
          exit;
     }
}