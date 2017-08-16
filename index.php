<?php
  require_once "DateChallengeFrontend.php";

  $FrontendHandler = new DateChallengeFrontend();

  $Result = ($FrontendHandler->getPOSTValue('action') == 'run') ? $FrontendHandler->run() : null;
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

  .generic-message {
   margin-bottom: 1em;
   padding: 5px;
  }

  .results {
    border: 2px solid green;
    background-color: #dfffcb;
  }

  .errors {
    border: 2px solid red;
    background-color: #ffcbcb;
  }

  .warning {
   border: 2px solid #c50;
   background-color: orange;
  }

  .method-name {
  font-style: italic;
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
   <div class="generic-message warning">
   <b>Please Note</b>:<br>
   This page is provided as a friendly UI for testing the DateChallenge class.  Minimal user input validation is done and this code should not be run on a public facing web server.
   </div>
   <?php
   if($Result) $Result->output();
   ?>
  <form method="post">
    <div class="input-group">
      <label for="fromTZ">Timezone for From date</label>
      <span class="form-input"><?php $FrontendHandler->printTimezoneSelector("fromTZ"); ?></span>
    </div>

    <div class="input-group">
      <label for="toTZ">Timezone for To date</label>
      <span class="form-input"><?php $FrontendHandler->printTimezoneSelector("toTZ"); ?></span>
    </div>

    <div class="input-group">
      <label for="dateFrom">Date From</label>
      <span class="form-input"><?php $FrontendHandler->printInput("dateFrom", "text", "datetime"); ?></span>
    </div>

    <div class="input-group">
      <label for="dateTo">Date To</label>
      <span class="form-input"><?php $FrontendHandler->printInput("dateTo", "text", "datetime"); ?></span>
    </div>

    <div class="input-group">
      <label for="dateTo">Format 'daysBetween' results as</label>
      <span class="form-input"><?php $FrontendHandler->printFormatSelector("daysResults", 'd');?></span>
    </div>

    <div class="input-group">
      <label for="dateTo">Format 'weekdaysBetween' results as</label>
      <span class="form-input"><?php $FrontendHandler->printFormatSelector("weekdaysResults", 'd');?></span>
    </div>

    <div class="input-group">
      <label for="dateTo">Format 'weeksBetween' results as</label>
      <span class="form-input"><?php $FrontendHandler->printFormatSelector("weeksResults", 'w');?></span>
    </div>

    <input type="submit" value="Calculate Results">
    <input type="hidden" name="action" value="run">
  </form>
 </body>
</html>
