<?php

/**
 * Time Range Validator - checks if stop time isn't before start time - it always throw global error
 * 
 * @uses sfValidatorBase
 * @package default
 * @version $id$
 * @copyright 
 * @author Wojciech Sznapka 
 * @license 
 */
class TimeRangeValidator extends sfValidatorSchema
{
  /**
   * configures validator
   * 
   * @param array $options 
   * @param array $messages 
   * @access protected
   * @return void
   */
  public function __construct($startField, $stopField, $options = array(), $messages = array())
  {  
    $this->addOption('start_field', $startField);
    $this->addOption('stop_field', $stopField);
    parent::__construct($options, $messages);
  }

  protected function configure($options, $messages)
  {
    $this->addMessage('invalidRange', 'Wartość czasu startowego (%start_field%) jest większa lub równa niż wartość czasu końcowego (%stop_field%)');
  }

  /**
   * return clean values 
   * 
   * @param mixed $values 
   * @access protected
   * @return values
   */
  protected function doClean($values)
  {  
    if (($start = $this->getOption('start_field')) && ($stop = $this->getOption('stop_field'))) {
      if (strtotime($values[$start]) > strtotime($values[$stop])) {
        $error = new sfValidatorError($this, 'invalidRange', array(
          'start_field'  => $values[$start],
          'stop_field'   => $values[$stop],
        ));
        throw $error;
      }
    }
    return $values;
  }  
}
