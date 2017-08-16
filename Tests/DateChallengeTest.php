<?php
use PHPUnit\Framework\TestCase;

class DateChallengeTest extends TestCase{

    // Set timezone one to Adelaide, Australia and timezone two to Perth, Australia.
    public function testCanSetTwoValidTimezones(){
      DateChallenge::setTimezones('Australia/Adelaide','Australia/Perth');
      $this->assertEquals('Australia/Adelaide', DateChallenge::getTimezoneOne());
      $this->assertEquals('Australia/Perth', DateChallenge::getTimezoneTwo());
    }

    // Set the first timezone to Adelaide, Australia.
    public function testCanSetOnlyFirstValidTimezone(){
      DateChallenge::setTimezones('Australia/Adelaide');
      $this->assertEquals('Australia/Adelaide', DateChallenge::getTimezoneOne());
      $this->assertEquals('Australia/Adelaide', DateChallenge::getTimezoneTwo());
    }

    // Set only the *second* timezone to Adelaide, Australia.
    public function testCanSetOnlySecondValidTimezone(){
      DateChallenge::setTimezones(null, 'Australia/Adelaide');
      $this->assertEquals('GMT', DateChallenge::getTimezoneOne());
      $this->assertEquals('Australia/Adelaide', DateChallenge::getTimezoneTwo());
    }

    public function testCannotSetInvalidTimezoneOne(){
        $this->expectException( Exception::class );
        DateChallenge::setTimezones('foobar');
    }

    public function testCannotSetInvalidTimezoneTwo(){
        $this->expectException( Exception::class );
        DateChallenge::setTimezones(null, 'foobar');
    }

    public function testCanCalculateValidDaysBetween(){
      DateChallenge::setTimezones('Australia/Adelaide','Australia/Adelaide');
      $this->assertEquals('1', DateChallenge::daysBetween(new DateTime('2018-01-01 00:00:00'), new DateTime('2018-01-02 00:00:00')) );
    }

    public function testCanAccountForTimezones(){
      DateChallenge::setTimezones('Australia/Adelaide', 'Australia/Melbourne');
      $this->assertEquals(0, DateChallenge::daysBetween(new DateTime('2017-01-01 10:00'), new DateTime('2017-01-01 10:30')));
    }

    public function testCanCalculateValidDaysBetweenLargerRange(){
      DateChallenge::setTimezones('Australia/Adelaide','Australia/Adelaide');
      $this->assertEquals('4', DateChallenge::daysBetween(new DateTime('2018-01-01 10:00:00'), new DateTime('2018-01-05 10:00:00')) );
    }

    public function testCanCalculateValidWeekDaysBetweenLargerRange(){
      DateChallenge::setTimezones('Australia/Adelaide');
      $this->assertEquals('3', DateChallenge::weekdaysBetween(new DateTime('2017-08-01 10:00:00'), new DateTime('2017-08-05 10:00:00')) );
    }

    public function testCanCalculateMicroRange(){
      DateChallenge::setTimezones('Australia/Adelaide');
      $this->assertEquals('30', DateChallenge::daysBetween(new DateTime('2018-01-01 10:00:00'), new DateTime('2018-01-01 10:00:30'), 's') );
    }

    public function testCannotUseInvalidDateArguments(){
      DateChallenge::setTimezones('Australia/Adelaide','Australia/Adelaide');
      $this->expectException( Exception::class );
      DateChallenge::daysBetween('foo', 'bar');
    }

}
?>