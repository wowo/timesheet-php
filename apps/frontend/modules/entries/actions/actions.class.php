<?php

/**
 * entries actions.
 *
 * @package    timesheet
 * @subpackage entries
 * @author     Wojciech Sznapka
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class entriesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $month = $request->getParameter('month', date('m'));
    $year  = $request->getParameter('year',  date('Y'));

    $entries = Doctrine::getTable('Entry')->findForMonthGroupped($month, $year);

    $this->entries = $entries;
    $this->month = strftime('%B', strtotime(implode('-', array(1, $month, $year))));
    $this->summary = Entry::getSummary($entries);
  }
}
