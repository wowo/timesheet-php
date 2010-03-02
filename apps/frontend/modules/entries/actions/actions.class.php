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
    $this->getContext()->getConfiguration()->loadHelpers('Date');
    $month = $request->getParameter('month', date('m'));
    $year  = $request->getParameter('year',  date('Y'));
    if ($month == date('m') && $year == date('Y')) {
      $form = new EntryForm();
    } else {
      $form = NULL;
    }

    $entries = Doctrine::getTable('Entry')->findForMonthGroupped($month, $year);

    $this->entries = $entries;
    $this->form    = $form;
    $this->month   = $month; 
    $this->summary = Entry::getSummary($entries);
    $this->year    = $year;
  }

  /**
   * adds entry 
   * 
   * @param sfWebRequest $request 
   * @access public
   * @return void
   */
  public function executeAdd(sfWebRequest $request)
  {
    if ($request->isMethod('post')) {
      $form = new EntryForm();
      $postData = $request->getParameter('entry', array());
      $postData['entry_date']['month'] = date('m');
      $postData['entry_date']['year']  = date('Y');
      $form->bind($postData);
      if ($form->isValid()) {
        $form->save();
        $entries = Doctrine::getTable('Entry')->findForMonthGroupped(date('m'), date('Y'));
        $entry = $entries[(int)$postData['entry_date']['day']];
        $result = array(
          'entry'   => array(
            'day' => (int)$entry->day,
            'dayLiteral' => $entry->getDayLiteral(),
            'workingTime' => TimeHelper::formatTime($entry->getWorkingTime()),
            'delta' => TimeHelper::formatTime($entry->getDelta()),
            'occurences' => $entry->occurences,
            'isDeltaNegative' => $entry->isDeltaNegative(),
          ),
          'summary' => Entry::getSummary($entries, true),
        );
        $this->getResponse()->setHttpHeader('Content-Type','application/json');
        return $this->renderText(json_encode($result));
      } else {
        $this->getResponse()->setStatusCode(409); //Conflict
        $this->getResponse()->setHttpHeader('Content-Type','application/json');
        return $this->renderText(json_encode($form->getErrorsAsArray()));
      }
    } else {
      $this->getResponse()->setStatusCode(412); //Precondition Failed
      return $this->renderText('Nieprawidłowa metoda wywołania');
    }
  }
}
