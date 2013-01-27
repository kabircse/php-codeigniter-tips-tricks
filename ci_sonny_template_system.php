$this->load->library('my_template', $configs);
$this->my_template->view('file_view', $data, 'specifix_template_or_leave_blank_for_default');

// in library file
//check initialize check active template
$current_template = ($active_template) OR $detaul_template;
//generate template_path
// get controller_name, action_name
$default_template_file = $controler_name . '.' . $action_name.'.tpl.php';

$content = $this->_ci->load->view('active_view', $data, TRUE);

$output = $this->load->template($default_template_file, array('content' => $content), TRUE);

$this->_ci->ouput->content = $output;

$var = "this is a really long variable and I'd rather have it " .
 "span over multiple lines for readability sake. God it's so hot in here " .
 "can someone turn on the A/C?";
