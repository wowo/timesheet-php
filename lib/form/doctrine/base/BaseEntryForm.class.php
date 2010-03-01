<?php

/**
 * Entry form base class.
 *
 * @method Entry getObject() Returns the current form's model object
 *
 * @package    timesheet
 * @subpackage form
 * @author     Wojciech Sznapka
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseEntryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'entry_date' => new sfWidgetFormDate(),
      'start_time' => new sfWidgetFormTime(),
      'stop_time'  => new sfWidgetFormTime(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'entry_date' => new sfValidatorDate(array('required' => false)),
      'start_time' => new sfValidatorTime(array('required' => false)),
      'stop_time'  => new sfValidatorTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('entry[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Entry';
  }

}
