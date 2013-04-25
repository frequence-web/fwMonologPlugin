<?php

/**
 * Listens to events related to fwMonologPlugin.
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class fwMonologListener
{
  /**
   * @var fwLoggerCollection
   */
  protected $loggerCollection;

  /**
   * @var sfEventDispatcher
   */
  protected $dispatcher;

  /**
   * @param sfEventDispatcher $dispatcher
   */
  public function bind(sfEventDispatcher $dispatcher)
  {
    $this->dispatcher = $dispatcher;
    $this->dispatcher->connect('context.method_not_found', array($this, 'onMethodNotFound'));
  }

  /**
   * @param sfEvent $event
   */
  public function onMethodNotFound(sfEvent $event)
  {
    if ('getMonolog' === $event['method'])
    {
      $event->setProcessed(true);
      $event->setReturnValue(call_user_func_array(array($this, 'getLogger'), $event['arguments']));
    }
  }

  public function initialize()
  {
    $this->loggerCollection = new fwLoggerCollection;
    $this->dispatcher->notify(new sfEvent($this->loggerCollection, 'fw_monolog.initialize'));
  }

  /**
   * @param string $name
   *
   * @return \Psr\Log\LoggerInterface
   */
  public function getLogger($name = null)
  {
    if (null === $this->loggerCollection)
    {
      $this->initialize();
    }

    if (null === $name && 1 === count($this->loggerCollection))
    {
      list($logger) = $this->loggerCollection->all();

      return $logger;
    }

    return $this->loggerCollection->get($name);
  }

  /**
   * @param sfEventDispatcher $dispatcher
   *
   * @return fwMonologListener
   */
  public static function createAndBind(sfEventDispatcher $dispatcher)
  {
    $listener = new static;
    $listener->bind($dispatcher);

    return $listener;
  }
}
