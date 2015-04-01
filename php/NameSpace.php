
**Name Space:***

Name Space: Name space is a collection of classes, functions and objects for removing name conflicts.


PHP Namespaces in 120 Seconds //Foo.php
class Foo {
      public function doAwesomeFooThings() {
            echo 'say Hi to the listeners';
   }
}


//use_foo.php
    require 'Foo.php';
    $foo = new Foo();

A namespace is like a directory and by adding “namespace”, Foo now lives in AcmeTools:
// Foo.php
namespace Acme\Tools;
class Foo {
          public function doAwesomeFooThings() {
         }
}

To use Foo, we have to call him by his fancy new name:
$foo = new \Acme\Tools\Foo();

This is just like referring to a file by its absolute path.
And that’s really it! Adding a namespace to a class is like organizing files from one directory, into a bunch of sub- directories. To refer to a class, use its fully-qualified name, starting with the slash. From here, it’s all gravy.
Since running around with this giant name is a drag, let’s add a shortcut:

use Acme\Tools\Foo as SomeFooClass;
 $foo = new SomeFooClass();
The use statement lets us call \Acme\Tools\Foo class by a nickname. Heck, we can call it anything, or just let it default to Foo:
use \Acme\Tools\Foo; $foo = new Foo();
Great? But what about old-school, non-namespaced PHP classes? For that, let’s pick on “DateTime”, a handy class that’s core to PHP, and got some new bells and whistles in PHP 5.3. For ever and ever, creating a new DateTime object looked the same: “new DateTime”:
// use_foo.php // ... $dt = new DateTime();
And if we’re in a normal file, this still works. But in a namespaced file, PHP thinks you’re talking about a class in the Acme\Tools namespace:
// Foo.php
namespace Acme\Tools;
 class Foo {
        public function doAwesomeFooThings() {
                  echo 'Hi listeners'; // Wrong! PHP will incorrectly think we mean Acme\Tools\DateTime! $dt = new                         DateTime();
       }
}
You can either refer to the class by its fully-qualified name - \DateTime:
$dt = new \DateTime();
or add a use statement:
// Foo.php
namespace Acme\Tools; use \DateTime;
 class Foo {
             public function doAwesomeFooThings() {
                      echo 'Hi listeners'; // Yay! $dt = new DateTime();
              }
 }

Yes, the use statement looks silly, but it tells PHP that when you say DateTime, you mean the non-namespaced class DateTime. Oh, and get rid of the beginning slash with the use statement - everything works completely the same with or without these, but you typically don’t see them:
use DateTime;

Site Link: //https://knpuniversity.com/screencast/php-namespaces-in-120-seconds


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
