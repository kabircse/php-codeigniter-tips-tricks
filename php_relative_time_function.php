function relativeTime($timestamp, $format = 'Y-m-d H:i'){
    $dif = time() - $timestamp;

    $dateArray = array(
        "second" => 60,     // 60 seconds in 1 minute
        "minute" => 60,     // 60 minutes in 1 hour
        "hour" => 24,       // 24 hours in 1 day
        "day" => 7,         // 7 days in 1 week
        "week" => 4,        // 4 weeks in 1 month
        "month" => 12,      // 12 months in 1 year
        "year" => 10        // Up to 10 years
    );

    foreach($dateArray as $key => $item){
        if($dif < $item)
            return $dif . ' ' . $key . ($dif == 1? '' : 's') . ' ago';
        $dif = round($dif/$item);
    }
    return date($format, $timestamp);
}

class Date_Difference
{
    public static function getStringResolved($date, $compareTo = NULL)
    {
        if(!is_null($compareTo)) {
            $compareTo = new DateTime($compareTo);
        }
        return self::getString(new DateTime($date), $compareTo);
    }

    public static function getString(DateTime $date, DateTime $compareTo = NULL)
    {
        if(is_null($compareTo)) {
            $compareTo = new DateTime('now');
        }
        $diff = $compareTo->format('U') - $date->format('U');
        $dayDiff = floor($diff / 86400);

        if(is_nan($dayDiff) || $dayDiff < 0) {
            return '';
        }
                
        if($dayDiff == 0) {
            if($diff < 60) {
                return 'Just now';
            } elseif($diff < 120) {
                return '1 minute ago';
            } elseif($diff < 3600) {
                return floor($diff/60) . ' minutes ago';
            } elseif($diff < 7200) {
                return '1 hour ago';
            } elseif($diff < 86400) {
                return floor($diff/3600) . ' hours ago';
            }
        } elseif($dayDiff == 1) {
            return 'Yesterday';
        } elseif($dayDiff < 7) {
            return $dayDiff . ' days ago';
        } elseif($dayDiff == 7) {
            return '1 week ago';
        } elseif($dayDiff < (7*6)) { // Modifications Start Here
            // 6 weeks at most
            return ceil($dayDiff/7) . ' weeks ago';
        } elseif($dayDiff < 365) {
            return ceil($dayDiff/(365/12)) . ' months ago';
        } else {
            $years = round($dayDiff/365);
            return $years . ' year' . ($years != 1 ? 's' : '') . ' ago';
        }
    }
}

// pass in a String DateTime, compared to another String DateTime (defaults to now)
$myString = Date_Difference::getStringResolved('-7 weeks');
$myString = Date_Difference::getStringResolved('-7 weeks', '+1 week');
 
// pass in a DateTime object, compared to another DateTime object (defaults to now)
// useful with the Propel ORM, which uses DateTime objects internally.
$myString = Date_Difference::getString(new DateTime('-7 weeks'));
$myString = Date_Difference::getString(new DateTime('-7 weeks'), new DateTime('+1 week'));

//Another way, simpler than above

function timeSince($time, $from = null)
    {
        if ($from == null) {
            $from = time();
        }
        $time = $from - $time;

        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'minute'),
            array(1 , 'second')
        );

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($time / $seconds)) != 0) {
                break;
            }
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
        return $print;
    }

//usage example
/*<span title="<?php echo date('r', $timestamp);?>"><?php echo $this->timeSince($timestamp);?></span>*/

function time_elapsed_string($ptime) {
$etime = time() - $ptime;

if ($etime < 1) {
return '0 seconds';
}

$a = array( 12 * 30 * 24 * 60 * 60 => 'year',
30 * 24 * 60 * 60 => 'month',
24 * 60 * 60 => 'day',
60 * 60 => 'hour',
60 => 'minute',
1 => 'second'
);

foreach ($a as $secs => $str) {
$d = $etime / $secs;
if ($d >= 1) {
$r = round($d);
return $r . ' ' . $str . ($r > 1 ? 's' : '');
}
}
}