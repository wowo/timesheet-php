<?php

//require_once '/usr/share/php/symfony/autoload/sfCoreAutoload.class.php';
require_once dirname(__FILE__) . '/../lib/symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
  }
}
