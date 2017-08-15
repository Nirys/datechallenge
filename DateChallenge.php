<?php

class DateChallenge {
  protected static $_instance;
  protected static $_resultFormats = [
    'd' => '$i / 60 / 60 / 24',
    's' => '$i',
    'i' => '$i / 60',
    'h' => '$i / 60 / 60',
    'y' => '$i / 60 / 60 / 24 / 365',
    'w' => '$i / 60 / 60 / 24 / 7'
  ];
  protected static $_weekdays = [1,2,3,4,5];

  protected $_resultFormatNames; // This will be populated in the constructor
  protected $_timezoneFrom;
  protected $_timezoneTo;

 /**
  * Set the timezones used for operations on the global instance.
  */
  public static function setTimezones($_tzFrom = null, $_tzTo = null){
    self::getInstance()->setInstanceTimezones($_tzFrom, $_tzTo);
  }

 /*
  * Get the name of timezone 1
  */
  public static function getTimezoneOne(){
    return self::getInstance()->_timezoneFrom->getName();
  }

 /*
  * Get the name of timezone 2
  */
  public static function getTimezoneTwo(){
    return self::getInstance()->_timezoneTo->getName();
  }

 /**
  * Retrieve (or create, if necessary) the global instance of the DateChallenge class
  * This will also initialize/re-configure the timezones on the global instance.
  */
  public static function getInstance($_tzFrom = null, $_tzTo = null){
    if(self::$_instance){
      // Only set timezone data if it was explicitly passed
      if($_tzFrom || $_tzTo){
        self::$_instance->setInstanceTimezones($_tzFrom, $_tzTo);
      }
      return self::$_instance;
    }
    self::$_instance = new self($_tzFrom, $_tzTo);
    return self::$_instance;
  }

 /**
  * Calculates the whole days between $dateFrom and $dateTo
  *
  * @param DateTime $dateFrom The start date for the period.
  * @param DateTime $dateTo The end date for the period - this must be after $dateFrom
  * @param string $resultAs The format in which to return a result, which may be one of
  * the following constants:
  * d - A whole number describing the time difference in days
  * s - A whole number describing the time difference in seconds
  * i - A whole number describing the time difference in minutes
  * h - A whole number describing the time difference in hours
  * y - A whole number describing the time difference in years
  * 
  *
  * @return integer
  */  
  public static function daysBetween($dateFrom, $dateTo, $resultAs = 'd'){
    $self = self::getInstance(); 
    return $self->abstractTimeBetween($dateFrom, $dateTo, $resultAs);
  }

 /**
  * Calculates the number of business days (Mon - Fri) between $dateFrom and $dateTo
  *
  * @param DateTime $dateFrom The start date for the period.
  * @param DateTime $dateTo The end date for the period - this must be after $dateFrom
  * @param string $resultAs The format in which to return a result, which may be one of
  * the following constants:
  * d - A whole number describing the time difference in days
  * s - A whole number describing the time difference in seconds
  * i - A whole number describing the time difference in minutes
  * h - A whole number describing the time difference in hours
  * y - A whole number describing the time difference in years
  * 
  *
  * @return integer
  */  
  public static function weekdaysBetween($dateFrom, $dateTo, $resultAs = 'd'){
    $self = self::getInstance(); 
    return $self->abstractTimeBetween($dateFrom, $dateTo, $resultAs, true);
  }

 /**
  * Calculates the number of whole weeks between $dateFrom and $dateTo
  *
  * @param DateTime $dateFrom The start date for the period.
  * @param DateTime $dateTo The end date for the period - this must be after $dateFrom
  * @param string $resultAs The format in which to return a result, which may be one of
  * the following constants:
  * d - A whole number describing the time difference in days
  * s - A whole number describing the time difference in seconds
  * i - A whole number describing the time difference in minutes
  * h - A whole number describing the time difference in hours
  * y - A whole number describing the time difference in years
  * 
  *
  * @return integer
  */  
  public static function weeksBetween($dateFrom, $dateTo, $resultAs = 'w'){
    $self = self::getInstance(); 
    return $self->abstractTimeBetween($dateFrom, $dateTo, $resultAs);
  }

 /**
  * Constructor.  Generally I assume people won't create an instance of DateChallenge
  * themselves, but will use the static methods which access $_instance.
  *
  * @param string $_tzFrom A valid PHP timezone descriptor string for all "from" dates, or null/ommitted to use GMT.
  * @param string $_tzTo A valid PHP timezone descriptor string for all "to" dates.  
  * If $_tzFrom is specified but $_tzTo is not, then $_tzFrom is assumed for $_tzTo.  If neither argument is specified, GMT is used.
  *
  * @return integer
  */  
  public function __construct($_tzFrom = null, $_tzTo = null){
    $this->_resultFormatNames = array_keys(self::$_resultFormats);

    $this->setInstanceTimezones($_tzFrom, $_tzTo);
  }
 /**
  *
  */
  protected function abstractTimeBetween($dateFrom, $dateTo, $resultAs = 'd', $weekdaysOnly = false){
    $this->validateArguments([
      '$dateFrom' => ['typeExpected' => 'DateTime', 'value' => $dateFrom, 'function' => 'is_datetime_object'], 
      '$dateTo' => ['typeExpected' => 'DateTime', 'value' => $dateTo, 'function' => 'is_datetime_object'],
      '$resultAs' => ['typeExpected'=> 'DateChallenge Result Type', 'value' => $resultAs, 'function' => 'is_valid_datechallenge_format']
    ]);

    $dateFrom->setTimezone($this->_timezoneFrom);
    $dateTo->setTimezone($this->_timezoneTo);

    // Iterating over the hours in a timespan is potentially ridiculously costly if using
    // long timespan intervals, and should probably be done better for that use case.
    // I decided to stick with it here for as a trade off of interval accuracy vs speed
    // (instead of using PT1S which was HORRIBLY costly) but I'd probably revise it if large
    // time intervals were expected.  
    $interval = new DateInterval('PT1H');  
    $period = new DatePeriod($dateFrom, $interval, $dateTo);
    $seconds = 0;
    foreach($period as $date){
      if(!$weekdaysOnly || in_array($date->format('N'), self::$_weekdays) ) $seconds+= 60 * 60;
    }

    return $this->formatDifference($seconds, $resultAs);
  }

 /**
  * Set the timezones used for operations.
  */
  protected function setInstanceTimezones($_tzFrom = null, $_tzTo = null){
    $this->_timezoneFrom = ($_tzFrom) ? new DateTimeZone($_tzFrom) : new DateTimeZone( 'GMT' );
    $this->_timezoneTo = ($_tzTo) ? new DateTimeZone($_tzTo) : new DateTimeZone( ($_tzFrom) ? $_tzFrom : 'GMT' );
  }

 /**
  * Helper method to validate that a given parameter is a DateTime object.
  */
  protected function is_datetime_object($var){
    return gettype($var)=='object' && get_class($var) == 'DateTime';
  }

 /**
  * Helper method to validate the a given parameter is a valid result format string
  */
  protected function is_valid_datechallenge_format($var){
    return in_array($var, $this->_resultFormatNames);
  }

 /**
  * Helper method to bulk validate arguments using internal functions
  */
  protected function validateArguments($argData){
    foreach($argData as $argName => $argData){
      if(! $this->{$argData['function']}($argData['value']) ){
        throw new Exception("$argName expected a value of type {$argData['typeExpected']}");
      }
    }
  }

  /**
  * Format the time value (given as seconds) as one of our accepted formats
  */
  protected function formatDifference($diffValue, $format){
    // Calculate the value of this DateInterval as a total number of seconds
    $calculation = str_replace('$i', $diffValue, self::$_resultFormats[$format]);
    eval('$diff = floor(' . $calculation .');');

    return $diff;
  }

}