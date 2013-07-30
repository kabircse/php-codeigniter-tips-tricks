echo strtotime('now');
echo strtotime('+4 days');
echo strtotime('+1 month');
echo strtotime('next monday');
echo strtotime('+2 weeks 3 days 4 hours 23 minutes');
/*
The second argument of strtotime is a timestamp, and its default value is the actual timestamp (time()). So echo strtotime('+4 days') is relative to the current time. Of course you can also give strtotime your mysql date! (Note you can also use the mysql function UNIX_TIMESTAMP, which use a bit more ressources).
*/
// more example
# on 2/8/2010
date('m/d/y', strtotime('first day')); # 02/01/10
date('m/d/y', strtotime('last day')); # 02/28/10
date('m/d/y', strtotime('last day next month')); # 03/31/10
date('m/d/y', strtotime('last day last month')); # 01/31/10
date('m/d/y', strtotime('2009-12 last day')); # 12/31/09 - this doesn't work if you reverse the order of the year and month
date('m/d/y', strtotime('2009-03 last day')); # 03/31/09
date('m/d/y', strtotime('2009-03')); # 03/01/09
date('m/d/y', strtotime('last day of march 2009')); # 03/31/09
date('m/d/y', strtotime('last day of march')); # 03/31/10


// Here is just another example, not relative to current date but to a particular date:

strtotime('23 hours ago', strtotime('2005-04-13 14:00'));

// This mean 23 hours ago relatively to the second given date, which must be a timestamp.

// Another easy and useful function is the famous mktime(). It returns also a UNIX timestamp:

$mydate = mktime(hour, minute, second, month, day, year);

$yearArray[] = date("Y-m-d", mktime(0,0,0,1,365,2008);

$my_date_time =  mktime(0, 0, 0, 12, 28, 2011);

/*+---------------- date to mysql datetime --------------------+*/
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

// PHP DATE COMPARISION
$exp_date = '2006-01-16'; // date format like as MySQL YYYY-MM-DD
$todays_date = date('Y-m-d');
$today = strtotime($todays_date);
$expiration_date = strtotime($exp_date);
if ($expiration_date > $today) {
    $valid = TRUE;
} else {
    $valid = FALSE;
}

// get total days in a specific month
function days_in_month($month, $year)
{
// calculate number of days in a month
return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
} 


// CHECK IS ON LOCAL
$localhosts = array('localhost', '127.0.0.1');
            if(in_array($_SERVER['HTTP_HOST'], $localhosts)){
                // turn on check
                $check = TRUE;
            }