<?php

class EntryTable extends Doctrine_Table
{
  /**
   * find entries for given month groupped by day, with number of entries per day 
   * 
   * @param mixed $month 
   * @param mixed $year 
   * @access public
   * @return void
   */
  public function findForMonthGroupped($month, $year)
  {
    $query = Doctrine_Query::create()
      ->select('day(entry_date) AS day')
      ->addSelect('entry_date')
      ->addSelect('sum((time_to_sec(stop_time) - time_to_sec(start_time)) / 60) AS minutes')
      ->addSelect('count(*) AS occurences')
      ->from('Entry INDEXBY day')
      ->addWhere('month(entry_date) = ?', (int)$month)
      ->addWhere('year(entry_date)  = ?', (int)$year)
      ->groupBy('entry_date');
    return $query->execute();
  }

  /**
   * find entries for given date groupped by day
   * 
   * @param mixed $date 
   * @access public
   * @return void
   */
  public function findEntriesForDateGroupped($date)
  {
    $query = Doctrine_Query::create()
      ->select('entry_date')
      ->addSelect('sum((time_to_sec(stop_time) - time_to_sec(start_time)) / 60) AS minutes')
      ->addSelect('count(*) AS occurences')
      ->from('Entry')
      ->addWhere('entry_date = ?', $date)
      ->groupBy('entry_date');
    return $query->fetchOne();
  }
     
}
