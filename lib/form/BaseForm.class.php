<?php

/**
 * Base project form.
 * 
 * @package    timesheet
 * @subpackage form
 * @author     Wojciech Sznapka 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
  public function getErrorsAsArray()
  {
    $errors = array('fields' => array(), 'global' => array());
    foreach ($this as $name => $field) {
      if ($field->hasError()) {
        $errors['fields'][$name] = $field->getError()->getMessage();
      }   
    }   

    if ($this->hasGlobalErrors()) {
      foreach ($this->getGlobalErrors() as $error) {
        $errors['global'][] = $error->getMessage();
      }   
    }   
    return $errors;
  }
}
