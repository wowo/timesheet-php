<?php
/**
 * TimeHelper 
 * 
 * @package default
 * @version $id$
 * @copyright 
 * @author Wojciech Sznapka
 * @license 
 */
class TimeHelper
{
  /**
   * format time in minutes to readable form HH:MM
   * 
   * @param mixed $time 
   * @access protected
   * @return string
   */
  public static function formatTime($time)
  {
    return sprintf('%s%d:%02d', ($time < 0) ? '-' : '',  floor(abs($time) / 60), abs($time) % 60);
  }
}
