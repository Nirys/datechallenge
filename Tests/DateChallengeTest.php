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
      $this->assertEquals('1', DateChallenge::daysBetween(new DateTime('2018-01-01'), new DateTime('2018-01-02')) );
    }

    public function testCannotUseInvalidDateArguments(){
      $this->expectException( Exception::class );
      DateChallenge::daysBetween('foo', 'bar');
    }

}
?>