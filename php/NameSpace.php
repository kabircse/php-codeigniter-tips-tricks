
**Name Space:***
Name Space: Name space is a collection of classes, functions and objects for removing name conflicts.

//Example:
<?php
//Process-1 usual including technique
//user.php
class user{
   function get_user(){}
}
?>

<?php
//member.php
include("user.php");
class member{
  function get_member(){};
}
$user_cls = NEW user();
?>

<?php
//Process-2:Using namespace
user.php
namespace person;//Creating a namespace named person using user classes from another, where typed use person.
class user{
  function get_user(){};
}
$user_cls = NEW person\user();//class
$user_fn = NEW person\user\get_user();//function
?>

<?php
//Process-3:Using namespace with alias(AS) another technique
//member.php
use person AS user/usercls;
$members = NEW person/get_member();
$user_cls = NEW user\usercls\user();//class
$user_fn = NEW user\usercls\user\get_user();//function
?>
