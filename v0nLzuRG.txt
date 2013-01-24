Register.php [Register Controller]

<?php

	
		class Register extends CI_Controller {


			public function index()
			{
				//Validation

				$rules = array( 

						"username" => array(
								"field" => "username",
								"label" => "Username",
								"rules" => "required|max_length[20]|min_length[5]|callback_username_is_taken"
							),
						"password" => array(
								"field" => "password",
								"label" => "Password",
								"rules" => "required|max_length[20]|min_length[6]"
							),
						"pass_conf" => array(
								"field" => "pass_conf",
								"label" => "Repeat Password",
								"rules" => "required|matches[password]"
							),
						"email" => array(
								"field" => "email",
								"label" => "E-Mail Address",
								"rules" => "required|valid_email|callback_email_is_taken"
							)

					);
				//Set the rules
				$this->form_validation->set_rules($rules);
				//Override Message : $this->form_validation->set_message('required', 'The %s field is empty!');
				//Checks to see if the form was submitted.
				if( $this->form_validation->run() != true ) {
					$this->load->view("vRegister"); //Display Page
				} else {
					
					$form = array();
					$form['username'] = $this->input->post("username");
					$form['password'] = md5($this->input->post("password"));
					$form['email']	  = $this->input->post("email");
					#Create user here.
					if( self::createUser( $form['username'], $form['password'], $form['email'] ) == true) {
						//Created User Successfully
						$data['username'] = $form['username'];
						$this->load->view("success_page", $data);
					} else {
						echo "Sorry, Couldn't Proccess Your Form!";
					}
				}
			}


			public function username_is_taken( $input ) {

				$query = "SELECT * FROM `users` WHERE `username` = ?";
				$arg   = array( $input );
				$exec  = $this->db->query($query, $arg) or die(mysql_error());

				if( $exec->num_rows() > 0 ) 
				{
					$this->form_validation->set_message('username_is_taken', 'Sorry the username <b> '.$input.' </b> is taken!');
					return FALSE;
				} else {
					return TRUE;
				}

			}

			public function email_is_taken( $input ) {

				$query = "SELECT * FROM `users` WHERE `email` = ?";
				$arg   = array( $input );
				$exec  = $this->db->query($query, $arg) or die(mysql_error());

				if( $exec->num_rows() > 0 ) 
				{
					$this->form_validation->set_message('email_is_taken', 'Sorry the email <b> '.$input.' </b> is taken! <a href="forgot_password"> Forgot Password? </a>');
					return FALSE;
				} else {
					return TRUE;
				}
			}


			 public function createUser( $user, $pass, $email )
			 {
			 	$query = "
			 		INSERT INTO `users` 
			 		(`username`,`password`,`email`,`date`,`ip`)
			 		VALUES (?,?,?,?,?)
			 	";

				$arg   = array( self::protect($user), self::protect($pass), $email, date("F j,Y"), $_SERVER['REMOTE_ADDR'] );
				
				if( $this->db->query($query, $arg) == true ) 
				{
					return TRUE; //Was Added To Databse `users` Succesfully.
				} else {
					return FALSE; //Problem with database or something.
				}

			 }


			public function protect( $str ) {
				return mysql_real_escape_string($str);
			}

		}


?>

vRegister.php [View Page]

<?=form_open(base_url()."register")?>

<table cellspacing="3" cellpadding="3">

	<tr><td>
		Username <td> <?=form_input(array("name"=>"username","value"=>set_value("username")))?>
		<td> <?=form_error("username") ?>
    </tr></td>			

    <tr><td>
		Password <td> <?=form_password(array("name"=>"password"))?>
		<td> <?=form_error("password") ?>
    </tr></td>
    <tr><td>
		Repeat Password <td> <?=form_password(array("name"=>"pass_conf"))?>
		<td> <?=form_error("pass_conf") ?>
    </tr></td>
    <tr><td>
		E-Mail Address <td> <?=form_input(array("name"=>"email","value"=>set_value("email")))?>
		<td> <?=form_error("email") ?>
    </tr></td>

    <tr><td>
    	<?=form_submit(array("name"=>"sumbit","value"=>"Register"))?>
    </td></tr>
</table>

<?=form_close()?>

success_page.php [View Page]

<?php

	echo "<center>";

	echo "<h1> Success </h1>";
	echo "Thank you for registering $username";
	echo "<br /> <a href='login'> Login Here </a>";

	echo "</center>";

?>

.htaccess file [For URL]

The forward slash is your URL. 

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    #Removes access to the system folder by users.
    #Additionally this will allow you to create a System.php controller,
    #previously this would not have been possible.
    #'system' can be replaced if you have renamed your system folder.
    RewriteCond %{REQUEST_URI} ^system.*
    RewriteRule ^(.*)$ /index.php?/$1 [L]
    
    #When your application folder isn't in the system folder
    #This snippet prevents user access to the application folder
    #Submitted by: Fabdrol
    #Rename 'application' to your applications folder name.
    RewriteCond %{REQUEST_URI} ^application.*
    RewriteRule ^(.*)$ /index.php?/$1 [L]

    #Checks to see if the user is attempting to access a valid file,
    #such as an image or css document, if this isn't true it sends the
    #request to index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?/$1 [L]
</IfModule>

<IfModule !mod_rewrite.c>
    # If we don't have mod_rewrite installed, all 404's
    # can be sent to index.php, and everything works as normal.
    # Submitted by: ElliotHaughin

    ErrorDocument 404 /index.php
</IfModule>