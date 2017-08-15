<?php
  require_once "DateChallenge.php";

  $tzList = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

  $dateFrom = isset($_POST['dateFrom']) ? $_POST['dateFrom'] : '';
  $dateTo = isset($_POST['dateTo']) ? $_POST['dateTo'] : '';

  if(isset($_POST['action'])){
    $Date1 = strtotime($dateFrom);
    $Date2 = strtotime($dateTo);
    $TZ1 = $_POST['tzFrom'];
    $TZ2 = $_POST['tzTo'];

//    $DaysBetween = DateChallenge::days    
  }

  function printTimezoneSelector($name, $selectedValue = null){
    global $tzList;

    if($selectedValue == null){
      $selectedValue = isset($_POST[$name]) ? $_POST[$name] : 'UTC';
    }
    ?>
    <select name="<?php echo $name; ?>"><?php
    foreach($tzList as $item){
      echo "<option value=\"$item\" " . ($item==$selectedValue ? 'selected' : '') . ">$item</option>";
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

    <input type="submit" value="Calculate Results">
    <input type="hidden" name="action" value="run">
  </form>
 </body>
</html>
