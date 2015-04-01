Difference BetweenMySQL function and MySQL Procedure with example:
1. AFUNCTION is always returns a value using the return statement. PROCEDURE mayreturn one or more values through parameters or may not return at all.
2. Functions are normally used for computationswhere as procedures are normally used for executing business logic.
3. Functions are not precompiled  where as  Stored procedure is precompiled execution plan.
4. Stored procedure has the security andreduces the network traffic and also we can call stored procedure in any no. ofapplications at a time.
5. A Function can be used in the SQL Querieswhile a procedure cannot be used in SQL queries that cause a major difference b/w function and procedures.
6.       
UDF Example:
CREATE FUNCTION hello (s CHAR(20))
   RETURNS CHAR(50)DETERMINISTIC
   RETURN CONCAT('Hello,',s,'!');
Query OK, 0 rows affected (0.00 sec)

CREATE TABLE names (id int, name varchar(20));
INSERT INTO names VALUES (1, 'Bob');
INSERT INTO names VALUES (2, 'John');
INSERT INTO names VALUES (3, 'Paul');

SELECT hello(name) FROM names;
+--------------+
| hello(name)  |
+--------------+
| Hello, Bob!  |
| Hello, John! |
| Hello, Paul! |
+--------------+
3 rows in set (0.00 sec)


SprocExample:
delimiter //

CREATE PROCEDURE simpleproc (IN s CHAR(100))
BEGIN
   SELECT CONCAT('Hello,', s, '!');
END//
Query OK, 0 rows affected (0.00 sec)

delimiter ;

CALL simpleproc('World');
+---------------------------+
| CONCAT('Hello, ', s, '!') |
+---------------------------+
| Hello, World!         	|
+---------------------------+
1 row in set (0.00 sec)


 Advantages ofStored Procedure:
1. Reuse/ This can certainly be accomplished within your code base but it beats thehell out of writing the same querry with 10 sub joins 15 times.

2. Storedprocedures are secure. Database administrator can grant appropriate permissionsto applications that access stored procedures in the database without givingany permission on the underlying database tables.

3. Adefined interface.

Disadvantages of Stored Procedure:
1. A constructs of stored procedures make it moredifficult to develop stored procedures that have complicated business logic.
2. It is difficult to debug stored procedures. Only fewdatabase management systems allow you to debug stored procedures. Unfortunately,MySQL does not provide facilities for debugging stored procedures.
It is not easy to develop and maintain storedprocedures. Developing and maintaining stored procedures are often requiredspecialized skill set that not all application developers possess. This maylead to problems in both application development and maintenance phases.


//StoredProcedure in mysql
//Procedure name user_p(). Just like SQL statements.
DELIMITER //
CREATE PROCEDURE user_p()
SELECT username,name FROM users; 



//Prodcedure insert_p for inserting data, IN - Input , name and datatype. 
DELIMITER //
CREATE PROCEDURE insert(IN username VARCHAR(50),IN name VARCHAR(50))

BEGIN

SET @username=username;
SET @name=name;

PREPARE STMT FROM
"INSERT INTO users(username,name) VALUES (?,?)";

EXECUTE STMT USING @username,@name;

END


//StoredProcecure in php
<?php
//Stored Procedure Needs mysqli
	$connect= mysqli_connect('localhost','root','','test');
if (!$connect)
{
printf("Can't connect to MySQL Server.", mysqli_connect_error());
exit;
}
	$sql = mysqli_query($connect,'CALL user_p()');

	echo 'Stored Procedure Results';
	while ($row = mysqli_fetch_array($sql)) {
		echo $row['u_name'].'-----'.$row['u_phone'].'<br/>';
	}
?>
