<?php

/**
 * Entry form.
 *
 * @package    timesheet
 * @subpackage form
 * @author     Wojciech Sznapka
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EntryForm extends BaseEntryForm
{
  /**
   * configures our Entry form 
   * 
   * @access public
   * @return void
   */
  public function configure()
  {
    $this->useFields(array('entry_date', 'start_time', 'stop_time'));
    $this->widgetSchema['entry_date']->setOption('format', '%day%');
    $this->widgetSchema->setLabels(
      array(
        'entry_date' => 'Dzień',
        'start_time' => 'Godzina początkowa',
        'stop_time'  => 'Godzina końcowa',
      )
    );
    $this
      ->setDefault('entry_date', date('Y-m-d'))
      ->setDefault('start_time', '8:00')
      ->setDefault('stop_time' , '16:00');
  }
}
