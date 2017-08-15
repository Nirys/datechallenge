<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
 </head>
 <body>
  <?php
  require_once "DateChallenge.php";

  $Date1 = new DateTime("2017-08-1");
  $Date2 = new DateTime("2017-08-30");

  $Days = DateChallenge::daysBetween($Date1, $Date2);

  echo "There are $Days between";
  ?>
 </body>
</html>
