<!DOCTYPE html><html><head><meta charset="utf-8" /><title>Get Server or Computer Mac address in PHP</title><meta content="How to getclient system or server mac address using PHP." name="description"  /><meta name="google-site-verification" content="liGddaK7I8_x0tSdKv36CRi_rMfRt3yMNjILkbOAxxY" /><link href='http://feeds2.feedburner.com/webinfopedia' rel='alternate' title='Webinfopedia-Learn SEO, Web Designing and Web development easily with example and demos' type='application/rss+xml'/><meta name="msvalidate.01" content="1CBFD6FA96646CD69CE09C869B2F6313" /><META name="y_key" content="2e447c925218040f" /><link rel="search" type="application/opensearchdescription+xml" href="http://www.webinfopedia.com/classes/opensearch.xml" title="SEO,PHP and Ajax blog" /> <meta content="mac address, php mac address, how to get mac address, php system mac id, system mac address, computer mac address, server mac id, get server mac address" name="keywords"  /><link rel="stylesheet" type="text/css" href="css/fb-notfication.css" media="screen" /><meta name="author" content="webinfopedia" /><meta name="copyright" content="webinfopedia.com" /><meta name="Robots" content="index, follow" /><meta name="language" content="English" /><link rel="icon" type="image/x-icon" href="http://www.webinfopedia.com/favicon.ico" />
<script type="text/javascript">  (function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po,s); })();</script>
</head><body><div style="text-align:center;"><h1 style="color:#333;">Get client system Mac Address in PHP.<a href="http://www.webinfopedia.com/php-get-system-mac-address.html" style="color:#6CA958; text-decoration:none; font-size:18px;">http://www.webinfopedia.com/php-get-system-mac-address.html</a></h1></div>
<div class="fbbg">
<p>Your MAc Address is</p>
<?php
// Turn on output buffering
ob_start();
//Get the ipconfig details using system commond
system('ipconfig /all');

// Capture the output into a variable
$mycom=ob_get_contents();
// Clean (erase) the output buffer
ob_clean();

$findme = "Physical";
//Search the "Physical" | Find the position of Physical text
$pmac = strpos($mycom, $findme);

// Get Physical Address
$mac=substr($mycom,($pmac+36),17);
//Display Mac Address
echo '<h1>'.$mac.'</h1>';
?>
</div><div style="padding:4px; text-align:right;"><h1><a href="http://www.webinfopedia.com/php-get-system-mac-address.html" style="font-weight:bold; color:#FFF; padding:4px 8px; background:#333; text-decoration:none;">Go back to tutorial</a></h1></div>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22897853-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script></body></html>
