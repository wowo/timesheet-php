<?php

/**
 * entries components 
 * 
 * @uses sfComponents
 * @package default
 * @version $id$
 * @copyright 
 * @author Wojciech Sznapka
 * @license 
 */
class entriesComponents extends sfComponents
{
  /**
   * execute month choose - shows select with months, automaticaly redirects to month after change.
   * it takes two arguments: current month and current year
   * 
   * @access public
   * @return void
   */
  public function executeMonthChoose()
  {
    $this->getContext()->getConfiguration()->loadHelpers('Date');
    $controller = $this->getController();
    $current   = $controller->genUrl(sprintf('@entry?year=%d&month=%d', $this->year, $this->month));
    $thisMonth = $controller->genUrl(sprintf('@entry?year=%d&month=%d', date('Y'), date('m')));
    $months = Doctrine::getTable('Entry')->findAvailableMonths();

    $choices = array();
    foreach ($months as $month) {
      $url = $controller->genUrl(sprintf('@entry?year=%d&month=%d', $month->year, $month->month));
      $choices[$url] = format_date(implode('-', array($month->year, $month->month, 1)), 'MMMM y');
    }
    if (!isset($choices[$current])) {
      $choices[$current] = format_date(implode('-', array($this->year, $this->month, 1)), 'MMMM y');
    }
    if (!isset($choices[$thisMonth])) {
      $choices[$thisMonth] = format_date(date('Y-m-1'), 'MMMM y');
    }

    $widget = new sfWidgetFormSelect(array('choices' => $choices));
    $this->widget = $widget->render('monthChoose', $current, array('onchange' => "window.location = this.value"));
  }
}
