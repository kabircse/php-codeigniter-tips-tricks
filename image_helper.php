function image_thumb($image_path, $height, $width)
{
    // Get the CodeIgniter super object
    $CI =& get_instance();

    // Path to image thumbnail
    // Maybe we should get image name, image extension for right extension and $rawname . '_' . $height . '_' . $withd . '.jpg';
    $image_thumb = dirname($image_path) . '/' . $height . '_' . $width . '.jpg';

    if( ! file_exists($image_thumb))
    {
        // LOAD LIBRARY
        $CI->load->library('image_lib');

        // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
        $CI->image_lib->initialize($config);
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }

    return '<img src="' . dirname($_SERVER['SCRIPT_NAME']) . '/' . $image_thumb . '" />';
}
// USAGE
/* echo image_thumb('assets/images/picture-1/picture-1.jpg', 50, 50); */

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */
