/*Mysql driver using process*/
$con = mysql_connect("DBhost", "DBuser", "DBpass");
mysql_select_db("database",$con);
$result = mysql_query("SELECT * FROM employee");
$res = mysql_fetch_assoc($result);

/*Mysqli  driver using process*/
$mysqli = new mysqli("DBhost", "DBuser", "DBpass", "database");
$result = $mysqli->query("SELECT * FROM employee");
$res = $result->fetch_assoc();

/*Just use PDO instead of the mysql_* functions.
SQL to create the test table :*/

CREATE TABLE `test`.`test` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL
) ENGINE = InnoDB;

/*Php to insert a row, then a second row which name contain the first one's ID.
 Connect to the mysql server*/

$db = new PDO('mysql:host=127.0.0.1;dbname=test;', $user, $pass);
// Set PDO to raise exceptions when a query fails
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->beginTransaction();
$stmt = $db->prepare('INSERT INTO test (name) VALUES(:name)');
// Insert first row
$stmt->execute(array(':name'=>'first data'));
// Get the inserted row's ID
$lastId = $db->lastInsertId();
// Insert the second row
$stmt->execute(array(':name' => 'First data ID was : '.$lastId));
$db->commit();

/*http://www.w3schools.com/php/func_mysqli_commit.asp
http://www.sitepoint.com/mysql-mistakes-php-developers/
*/
