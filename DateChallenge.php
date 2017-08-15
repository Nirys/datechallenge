<?php

class DateChallenge {
  protected static $_instance;
  protected static $_resultFormats = ['d' ,'s', 'i', 'h', 'y'];

  protected $_timezoneFrom;
  protected $_timezoneTo;

 /**
  * Set the timezones used for operations on the global instance.
  */
  public static function setTimezones($_tzFrom = null, $_tzTo = null){
    self::getInstance()->setTimezones($_tzFrom, $_tzTo);
  }

 /**
  * Retrieve (or create, if necessary) the global instance of the DateChallenge class
  * This will also initialize/re-configure the timezones on the global instance.
  */
  public static function getInstance($_tzFrom = null, $_tzTo = null){
    if(self::$_instance){
      self::$_instance->setInstanceTimezones($_tzFrom, $_tzTo);
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

    // Validates the arguments are of the expected types using local functions,
    // throwing an exception if they aren't.
    $self->validateArguments([
      '$dateFrom' => ['typeExpected' => 'DateTime', 'value' => $dateFrom, 'function' => 'is_datetime_object'], 
      '$dateTo' => ['typeExpected' => 'DateTime', 'value' => $dateTo, 'function' => 'is_datetime_object'],
      '$resultAs' => ['typeExpected'=> 'DateChallenge Result Type', 'value' => $resultAs, 'function' => 'is_valid_datechallenge_format']
    ]);

    return 0;
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
    $this->setInstanceTimezones($_tzFrom, $_tzTo);
  }

 /**
  * Set the timezones used for operations.
  */
  protected function setInstanceTimezones($_tzFrom = null, $_tzTo = null){
    $this->_timezoneFrom = ($_tzFrom) ? new DateTimeZone($_tzFrom) : new DateTimeZone( 'GMT' );
    $this->_timezoneTo = ($_tzTo) ? new DateTimeZone($_tzTo) : new DateTimeZone( 'GMT' );
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
    return in_array($var, self::$_resultFormats);
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

}