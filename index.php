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


  $Date1 = new DateTime("2017-01-4 10:00:00");
  $Date2 = new DateTime("2017-08-7 11:00:00");

  DateChallenge::setTimezones('Australia/Adelaide','Australia/Perth');

  $Days = DateChallenge::daysBetween($Date1, $Date2, 's');
  $WeekDays = DateChallenge::weekdaysBetween($Date1, $Date2);
  $Weeks = DateChallenge::weeksBetween($Date1, $Date2);
  echo "There are $Days between and $WeekDays weekdays and $Weeks weeks between";
  ?>
 </body>
</html>
