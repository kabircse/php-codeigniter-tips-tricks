//
// Codeigniter native SESSION
//
//Inside config.php there is a option which is default to use cookies:

$config['sess_driver'] = 'cookie';

//Description

//'sess_driver'= the driver to load: cookie (Classic), native (PHP sessions),

//So it looks like you could change this to use native PHP sessions.


//codeigniter get database from enywhere
	$ci=& get_instance();
        $ci->load->database(); 

        $sql = "select * from table"; 
        $query = $ci->db->query($sql);
        $row = $query->result();
//
// resize image
//
public function do_resize()
{
    $filename = $this->input->post('new_val');
    $source_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/avatar/tmp/' . $filename;
    $target_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/avatar/';
    $config_manip = array(
        'image_library' => 'gd2',
        'source_image' => $source_path,
        'new_image' => $target_path,
        'maintain_ratio' => TRUE,
        'create_thumb' => TRUE,
        'thumb_marker' => '_thumb',
        'width' => 150,
        'height' => 150
    );
    $this->load->library('image_lib', $config_manip);
    if (!$this->image_lib->resize()) {
        echo $this->image_lib->display_errors();
    }
    // clear //
    $this->image_lib->clear();
}


// Stored in an array with this prototype: $this->config['blog_settings'] = $config
$this->config->load('blog_settings', TRUE);
//To retrieve an item from your config file, use the following function:
$this->config->item('item name');

//Where item name is the $config array index you want to retrieve. For example, to fetch your language choice you'll do this:
$lang = $this->config->item('language');

//The function returns FALSE (boolean) if the item you are trying to fetch does not exist.

//The function returns FALSE (boolean) if the item you are trying to fetch does not exist.

//If you are using the second parameter of the $this->config->load function in order to assign your //config items to a specific index you can retrieve it by specifying the index name in the second //parameter of the $this->config->item() function. Example:
// Loads a config file named blog_settings.php and assigns it to an index named "blog_settings"
$this->config->load('blog_settings', TRUE);

// Retrieve a config item named site_name contained within the blog_settings array
$site_name = $this->config->item('site_name', 'blog_settings');

// An alternate way to specify the same item:
$blog_config = $this->config->item('blog_settings');
$site_name = $blog_config['site_name'];
//manual for this
//http://ellislab.com/codeigniter/user-guide/libraries/config.html

// AUTO LOAD LIBRARY CONFIGURATION
//If there is a config/libraryname.php file, it will be automatically loaded, just before library instanciation.

//(so, beware of name conflicts with CI's config files)


//Side note: this autoloading is disabled if you pass an array as the 2nd argument:

$this->load->library('thelibrary', array('param1' => 'value1'));

// valid a email in codeigniter
function valid_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

// codeingiter add class for form element if It's not validated
<input name="your_field_name" class="control-group <?php if (form_error('your_field_name')) echo ' class="error"'; ?>">