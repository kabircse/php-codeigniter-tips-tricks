<?php
/*+-----------------------------------------------------------------------------+*/
// You are actually saying assign $a by reference to $b.
$a = 42;
$b =& $a;
$array = array('apple', 'orange', 'banana');
// reference in foreach loop
foreach($array as &$d)
{
    $d = 'fruit';
}
echo implode(', ', $array); // output: fruit, fruit, fruit
/*+-----------------------------------------------------------------------------+*/

/*+-----------------------------------------------------------------------------+*/
// assignment in IF condition
$b = FALSE;
if ($a = $b) {
    echo 'Hello world';
}
// output nothing because $a has value to FALSE
/*+-----------------------------------------------------------------------------+*/

$mynum = $mynum + $num;
// It should not be above, is equivalent to
$mynum += $num;

/*+-----------------------------------------------------------------------------+*/
$var = "my name is bob";
// It should be as above
$var = 'my name is bob';
// because php compile "" but not compile ''
/*+-----------------------------------------------------------------------------+*/


/* please make your code clean & easy to read */
//bad to read
if($someCondition==true){ doSomething();
        if($otherCondition==true){ doSomethingElse($someVariable); }else{ doSomethingElse($otherVariable); } }
// good to read
if( $someCondition == true ) {
        doSomething();
        if( $otherCondition == true ) {
            doSomethingElse( $someVariable );
        } else {
            doSomethingElse( $otherVariable );
        }
    }
// and better than above

if( $someCondition == true ) {
 
        doSomething();
 
        if( $otherCondition == true ) {
 
            doSomethingElse( $someVariable );
            doSomething( $someVariable );
 
        } else {
 
            doSomethingElse( $otherVariable );
            doSomething( $someVariable );
 
        }
 
    }

/* using some php keyword */

//using static keyword for singleton pattern
//or check data was loaded,
//
function get_data($data_key) {
	static $dataset; 
	if(!isset($dataset[$data_key])) {
		//query database or something like that to get data 
		//set data to static variable
	}
	return $dataset[$data_key];
}
//usage example
get_data('lastest_event');
//after that, somewhere has recall
//data was loaded, so we don't reload
get_data('lastest_event');

//static method for object instance		
function drupal_container(Container $new_container = NULL) {
  // We do not use drupal_static() here because we do not have a mechanism by
  // which to reinitialize the stored objects, so a drupal_static_reset() call
  // would leave Drupal in a nonfunctional state.
  static $container;
  if (isset($new_container)) {
    $container = $new_container;
  }
  return $container;
}

// get file extension
function get_file_extension($file_name) {
  return substr(strrchr($file_name,'.'),1);
}

$filename = substr($file_full_path, strrpos($file_full_path, '/') + 1);
// get file name without extension
$filename_without_extension = substr($filename, 0, strrpos($filename, '.'));
// get file extension
$fileext = substr($filename, strrpos($filename, '.') + 1);
// check http has ssl
$http = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';

// from wordpress/wp-includes/functions.php
function is_ssl() {
   if ( isset($_SERVER['HTTPS']) ) {
       if ( 'on' == strtolower($_SERVER['HTTPS']) )
           return true;
       if ( '1' == $_SERVER['HTTPS'] )
           return true;
   } elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' ==
$_SERVER['SERVER_PORT'] ) ) {
       return true;
   }
   return false;
}
