<?php

class EntryTable extends Doctrine_Table
{
  /**
   * find entries for given month groupped by day, with number of entries per day 
   * 
   * @param mixed $month 
   * @param mixed $year 
   * @access public
   * @return Entry[]
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
      ->groupBy('entry_date')
      ->orderBy('entry_date');
    return $query->execute();
  }

  /**
   * find months (with years) in which user has entries
   * 
   * @access public
   * @return Entry[]
   */
  public function findAvailableMonths()
  {
    $query = Doctrine_Query::create()
      ->select('DISTINCT month(entry_date) AS month, year(entry_date) AS year')
      ->from('Entry')
      ->orderBy('entry_date DESC');
    return $query->execute();
  }
}
