<?php
require_once "DateChallenge.php";
require_once "DateChallengeResult.php";

class DateChallengeFrontend {
  private $_formatList;
  private $_tzList;

  public function __construct(){
    $this->_tzList = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    $this->_formatList = DateChallenge::listFormats();
  }

  public function printFormatSelector($name, $default = 'd'){
    $this->printGenericSelector($name, $this->_formatList, $default);
  }

  public function printTimezoneSelector($name){
    $this->printGenericSelector($name, $this->_tzList, 'UTC', false);
  }

  public function printInput($name, $inputType, $cssClass){
    $value = $this->getPOSTValue($name, '');
    ?><input class="<?php echo $cssClass; ?>" type="text" name="<?php echo $name;?>" value="<?php echo $value; ?>"><?php
  }

  public function run(){
    $Result = new DateChallengeResult( $this );

    if($Result->validate()){
      $Result->runDaysBetween();
      $Result->runWeekdaysBetween();
      $Result->runWeeksBetween();
    }
    return $Result;
  }

  private function printGenericSelector($name, $fromList, $default = null, $assocArray = true){
    $selectedValue = $this->getPOSTValue($name, $default);
    ?>
    <select name="<?php echo $name; ?>"><?php
    foreach($fromList as $key=>$item){
      $value = ($assocArray ? $key : $item);
      echo "<option value=\"" . $value . "\" " . ($value==$selectedValue ? 'selected' : '') . ">$item</option>";
    }
    ?></select>
    <?php
  }

  public function getPOSTValue($key, $default = null){
    return isset($_POST[$key]) ? $_POST[$key] : $default;
  }
}