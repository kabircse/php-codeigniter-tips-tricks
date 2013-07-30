//
// A very simple PHP example that sends a HTTP POST to a remote site
//

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://www.mysite.com/tester.phtml");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postvar1=value1&postvar2=value2&postvar3=value3");

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

// further processing ....
if ($server_output == "OK") { ... } else { ... }


# END SIMPLE
# GET JSON DATA
// jSON URL which should be requested
$json_url = 'http://www.mydomain.com/json_script.json';
 
$username = 'your_username';  // authentication
$password = 'your_password';  // authentication
 
// jSON String for request
$json_string = '[your json string here]';
 
// Initializing curl
$ch = curl_init( $json_url );
 
// Configuring curl options
$options = array(
CURLOPT_RETURNTRANSFER => true,
CURLOPT_USERPWD => $username . ":" . $password,   // authentication
CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
CURLOPT_POSTFIELDS => $json_string
);
 
// Setting curl options
curl_setopt_array( $ch, $options );
 
// Getting results
$result =  curl_exec($ch); // Getting jSON result string
# END GET JSON DATA


//extract data from the post
extract($_POST);

//set POST variables
$url = 'http://domain.com/get-post.php';
$fields = array(
            'lname' => urlencode($last_name),
            'fname' => urlencode($first_name),
            'title' => urlencode($title),
            'company' => urlencode($institution),
            'age' => urlencode($age),
            'email' => urlencode($email),
            'phone' => urlencode($phone)
        );

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//bellow for config ssl
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/CAcerts/BuiltinObjectToken-EquifaxSecureCA.crt");

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
// for further reading, go to http://davidwalsh.name/curl-post

# ANOTHER WAY TO DO

// I did something like this:

$foo["data"] = base64_encode(json_encode($_POST));

$url = 'http://domain.com/get-post.php';

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$foo);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
//…

//The script its receive the data:

//inverse proccess
$data = json_decode(base64_decode($_POST["data"]));

// you don’t need to urlencode, reparse objects, url-ify fields, the data travel “encrypted” and you can send more complex data structures