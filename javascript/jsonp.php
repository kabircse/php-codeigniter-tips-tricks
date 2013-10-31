<?php
$firstname = isset($_GET['firstname']) ? $_GET['firstname'] : '';
if ($firstname == 'Jeff') {
  header("Content-Type: application/json");
  echo $_GET['callback'] . '(' . "{'fullname' : 'Jeff Hansen'}" . ')';
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>jsonp example</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
      $.getJSON('./jsonp.php?callback=?', 'firstname=Jeff', function(res) {
        alert('Your name is ' + res.fullname);
      });
    </script>
  </head>
  <body>
  </body>
</html>
