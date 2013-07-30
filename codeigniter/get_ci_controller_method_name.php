//You could use the URI Class:

$this->uri->segment(n); // n=1 for controller, n=2 for method, etc

//I've also been told that the following work, but am currently unable to test:

$this->router->fetch_class();
$this->router->fetch_method();

$ci =& get_instance();
$ci->router->fetch_class();

//There's also a 
$ci->router->fetch_method(); 
//method if you need the name of the method called for any reason.
//sanitize file name
$filename = $this->security->sanitize_filename($this->input->post('filename'));