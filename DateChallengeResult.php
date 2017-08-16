<?php

class DateChallengeResult {
  protected $errors;
  protected $days;
  protected $weekdays;
  protected $weeks;
  protected $success;
  protected $dateFrom;
  protected $dateTo;
  protected $dtFrom;
  protected $dtTo;
  protected $tzFrom;
  protected $tzTo;
  protected $weeksResultsFmt;
  protected $daysResultsFmt;
  protected $weekdaysResultsFmt;
  protected $resultLine = '<span class="method-name">%s</span> returned %s as a value of %s<br>';

  public function __construct($dcFrontend){
    $this->errors = array();
    $this->days = 0;
    $this->weekdays = 0;
    $this->weeks = 0;
    $this->success = false;
    $this->dateFrom = $dcFrontend->getPOSTValue('dateFrom');
    $this->dateTo = $dcFrontend->getPOSTValue('dateTo');

    $this->tzFrom = $dcFrontend->getPOSTValue('fromTZ');
    $this->tzTo = $dcFrontend->getPOSTValue('toTZ');

    $this->formats = DateChallenge::listFormats();

    $this->weeksResultsFmt = $dcFrontend->getPOSTValue('weeksResults');
    $this->daysResultsFmt = $dcFrontend->getPOSTValue('daysResults');
    $this->weekdaysResultsFmt = $dcFrontend->getPOSTValue('weekdaysResults');
  }

  public function runDaysBetween(){
    DateChallenge::setTimezones($this->tzFrom, $this->tzTo);
    $this->days = DateChallenge::daysBetween($this->getFromDate(), $this->getToDate(), $this->daysResultsFmt);
  }

  public function runWeekdaysBetween(){
    DateChallenge::setTimezones($this->tzFrom, $this->tzTo);
    $this->weekdays = DateChallenge::daysBetween($this->getFromDate(), $this->getToDate(), $this->weekdaysResultsFmt);
  }

  public function runWeeksBetween(){
    DateChallenge::setTimezones($this->tzFrom, $this->tzTo);
    $this->weeks = DateChallenge::daysBetween($this->getFromDate(), $this->getToDate(), $this->weeksResultsFmt);
  }

  public function validate(){
    if( $this->dateFrom == '' ){
      $this->errors[] = "Please enter start date";
    }else{
      $this->dtFrom = new DateTime( $this->dateFrom, new DateTimeZone($this->tzFrom) );
    }

    if( $this->dateTo == '' ){
      $this->errors[] = "Please enter end date";
    }else{
      $this->dtTo = new DateTime( $this->dateTo, new DateTimeZone($this->tzTo) );
    }

    $this->success = sizeof($this->errors) == 0;
    return $this->success;
  }

  public function getSuccess(){
    return $this->success;
  }

  public function getFromDate(){
    return $this->dtFrom;
  }

  public function getToDate(){
    return $this->dtTo;
  }

  public function output(){
    ?><div class="generic-message <?php echo $this->getSuccess() ? 'results' : 'errors'; ?>"><?php
      if($this->getSuccess()){
        $this->outputResults();
    }else {
        $this->outputErrors();
    }
    ?></div><?php
  }

  protected function outputErrors(){
   foreach($Result->errors as $message) echo $message . '<br>';
  }

  protected function outputResults(){
    echo "Results between " . $this->prettyDate( $this->getFromDate() ) . ' and ' . $this->prettyDate( $this->getToDate() ) . '<br>';
    printf($this->resultLine, "daysBetween", $this->days, $this->formats[ $this->daysResultsFmt ]);
    printf($this->resultLine, "weekdaysBetween", $this->weekdays, $this->formats[ $this->weekdaysResultsFmt ]);
    printf($this->resultLine, "weeksBetween", $this->weeks, $this->formats[ $this->weeksResultsFmt ]);
  }

  protected function prettyDate($dateObj){
    return $dateObj->format('l M d Y, H:i:s') . ' in ' . $dateObj->format('e');
  }


}