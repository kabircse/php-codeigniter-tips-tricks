/*+---------------- date to mysql datetime --------------------+*/

/*One common solution is to store the dates in DATETIME fields and use PHPs date() and strtotime() functions to convert between PHP timestamps and MySQL DATETIMEs. The methods would be used as follows -
*/
    $phpdate = strtotime( $mysqldate );
    $mysqldate = date( 'Y-m-d H:i:s', $phpdate );
    

/*Our second option is to let MySQL do the work. MySQL has functions we can use to convert the data at the point where we access the database. UNIX_TIMESTAMP will convert from DATETIME to PHP timestamp and FROM_UNIXTIME will convert from PHP timestamp to DATETIME. The methods are used within the SQL query. So we insert and update dates using queries like this -*/

    $query = "UPDATE table SET
        datetimefield = FROM_UNIXTIME($phpdate)
        WHERE...";
    $query = "SELECT UNIX_TIMESTAMP(datetimefield)
        FROM table WHERE...";

/*Our last option is simply to use the PHP timestamp format everywhere. Since a PHP timestamp is a signed integer, use an integer field in MySQL to store the timestamp in. This way there’s no conversion and we can just move PHP timestamps into and out of the database without any issues at all.

Be aware, however, that by using an integer field to store your dates you lose a lot of functionality within MySQL because MySQL doesn’t know that your dates are dates. You can still sort records on your date fields since php timestamps increase regularly over time, but if you want to use any of MySQL’s date and time functions on the data then you’ll need to use FROM_UNIXTIME to get a MySQL DATETIME for the function to work on.

However, if you’re just using the database to store the date information and any manipulation of it will take place in PHP then there’s no problems.*/

/*+--------------------- some ways to make a php date to MySQL datetime ---+*/

$date = mysql_real_escape_string($_POST['intake_date']);
 
//1. If your MySQL column is DATE type:
 
$date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
 
//2. If your MySQL column is DATETIME type:
 
$date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)));
 
//You haven't got to work strototime(), because it will not work with dash - separators, it will try //to do a subtraction.
 
//Update, the way your date is formatted you can't use strtotime(), use this code instead:
 
$date = '02/07/2009 00:07:00';
$date = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $date);
echo $date;
 
//Output:
 
//2009-07-02 00:07:00