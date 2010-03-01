<?php

/**
 * Entry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    timesheet
 * @subpackage model
 * @author     Wojciech Sznapka
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Entry extends BaseEntry
{
  /**
   * get day in literal form
   * 
   * @access public
   * @return string
   */
  public function getDayLiteral()
  {
    return strftime('%A', strtotime($this->entry_date));
  }

  /**
   * calculate delta - only if workDayHours configured  in app.yml
   * 
   * @access private
   * @return integer
   */
  public function getDelta()
  {
    if ($workingDayHours = sfConfig::get('app_timesheet_workDayHours')) {
      return $this->minutes - ($workingDayHours * 60);
    } else {
      return 0;
    }
  }

  /**
   * determines wether delta is negative
   * 
   * @access public
   * @return boolean
   */
  public function isDeltaNegative()
  {
    return ($this->getDelta() < 0);
  }

  /**
   * gets working time for day - it can be calculated from few entries
   * 
   * @access public
   * @return string
   */
  public function getWorkingTime()
  {
    return $this->minutes;
  }

  /**
   * gets summary from given entries
   * 
   * @param mixed $entries 
   * @static
   * @access public
   * @return array
   */
  public static function getSummary($entries, $formated = false)
  {
    $summary = array(
      'delta' => 0,
      'occurences' => 0,
      'sum' => 0,
    );
    foreach ($entries as $entry) {
      $summary['sum'] += $entry->minutes;
      $summary['occurences'] += $entry->occurences;
      $summary['delta'] += $entry->getDelta();
    }
    if ($formated) {
      $summary['sum'] = TimeHelper::formatTime($summary['sum']);
      $summary['delta'] = TimeHelper::formatTime($summary['delta']);
    }
    return $summary;
  }
}
