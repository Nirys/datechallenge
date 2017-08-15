<?php
  require_once "DateChallenge.php";

  echo DateChallenge::weekdaysBetween(new DateTime('2018-01-02 10:00:00'), new DateTime('2018-01-06 10:00:00'),'s');
  die;


  $tzList = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
  $formatList = DateChallenge::listFormats();

  $dateFrom = isset($_POST['dateFrom']) ? $_POST['dateFrom'] : '';
  $dateTo = isset($_POST['dateTo']) ? $_POST['dateTo'] : '';

  if(isset($_POST['action'])){
    $Date1 = strtotime($dateFrom);
    $Date2 = strtotime($dateTo);
    $TZ1 = $_POST['fromTZ'];
    $TZ2 = $_POST['toTZ'];

  }

  function printFormatSelector($name, $default = 'd'){
    global $formatList;
    printGenericSelector($name, $formatList, $default);
  }

  function printTimezoneSelector($name){
    global $tzList;
    printGenericSelector($name, $tzList, 'UTC', false);
  }

  function printGenericSelector($name, $fromList, $default = null, $assocArray = true){
    $selectedValue = isset($_POST[$name]) ? $_POST[$name] : $default;
    ?>
    <select name="<?php echo $name; ?>"><?php
    foreach($fromList as $key=>$item){
      $value = ($assocArray ? $key : $item);
      echo "<option value=\"" . $value . "\" " . ($value==$selectedValue ? 'selected' : '') . ">$item</option>";
    }
    ?></select>
    <?php
  }
?>
<!doctype html>
<html lang="en">
 <head>
  <title>Use the DateChallenge Class</title>
  <style>
  body{
  font-family: Arial;
  padding: 20px;
  }

  label {
    width: 250px;
    display: inline-block;
  }

  .form-input {
    width: 200px;
    display: inline-block;
  }

  .input-group {
    margin-top: 5px;
    margin-bottom: 5px;
  }
  </style>
  <script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" />
  <script language="javascript">
  jQuery(window).load(function(){
    jQuery('.datetime').datetimepicker({format: 'Y-m-d H:i:s'});
  });
  </script>
 </head>
 <body>
   <h1>Use the DateChallenge Class</h1>
  <form method="post">
    <div class="input-group">
      <label for="fromTZ">Timezone for From date</label>
      <span class="form-input"><?php printTimezoneSelector("fromTZ"); ?></span>
    </div>

    <div class="input-group">
      <label for="toTZ">Timezone for To date</label>
      <span class="form-input"><?php printTimezoneSelector("toTZ"); ?></span>
    </div>

    <div class="input-group">
      <label for="dateFrom">Date From</label>
      <span class="form-input"><input class="datetime" type="text" name="dateFrom" value="<?php echo $dateFrom; ?>"></span>
    </div>

    <div class="input-group">
      <label for="dateTo">Date To</label>
      <span class="form-input"><input class="datetime" type="text" name="dateTo" value="<?php echo $dateTo; ?>"></span>
    </div>

    <div class="input-group">
      <label for="dateTo">Format 'daysBetween' results as</label>
      <span class="form-input"><?php printFormatSelector("daysResults", 'd');?></span>
    </div>

    <div class="input-group">
      <label for="dateTo">Format 'weekdaysBetween' results as</label>
      <span class="form-input"><?php printFormatSelector("daysResults", 'd');?></span>
    </div>

    <div class="input-group">
      <label for="dateTo">Format 'weeksBetween' results as</label>
      <span class="form-input"><?php printFormatSelector("daysResults", 'w');?></span>
    </div>

    <input type="submit" value="Calculate Results">
    <input type="hidden" name="action" value="run">
  </form>
 </body>
</html>
