<?php

/**
 * Plugin config.
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class fwMonologPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @var fwMonologListener
   */
  protected $listener;

  public function initialize()
  {
    $this->listener = fwMonologListener::createAndBind($this->dispatcher);
  }
}
