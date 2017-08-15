<?php

class DateChallenge {
  protected static $_instance;
  protected $_timezoneFrom;
  protected $_timezoneTo;

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
    $this->setTimezones($_tzFrom, $_tzTo);
  }

  protected function setTimezones($_tzFrom = null, $_tzTo = null){
    $this->_timezoneFrom = ($_tzFrom) ? new DateTimeZone($_tzFrom) : new DateTimeZone( 'GMT' );
    $this->_timezoneTo = ($_tzTo) ? new DateTimeZone($_tzTo) : new DateTimeZone( 'GMT' );
  }

 /**
  * Retrieve (or create, if necessary) the global instance of the DateChallenge class
  * This will also initialize/re-configure the timezones on the global instance.
  */
  public static function getInstance($_tzFrom = null, $_tzTo = null){
    if(self::$_instance){
      self::$_instance->setTimezones($_tzFrom, $_tzTo);
      return self::$_instance;
    }
    self::$_instance = new self($_tzFrom, $_tzTo);
    return self::$_instance;
  }

  public function setTimezone($_tzFrom, $_tzTo = null){
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

}