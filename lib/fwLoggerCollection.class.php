<?php

use Psr\Log\LoggerInterface;

/**
 * A collection of \Psr\Log\LoggerInterface instances
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class fwLoggerCollection implements Countable
{
  /**
   * @var LoggerInterface[]
   */
  protected $loggers = array();

  /**
   * @param LoggerInterface[] $loggers
   */
  public function __construct(array $loggers = array())
  {
    foreach ($loggers as $name => $logger)
    {
      $this->add($name, $logger);
    }
  }

  /**
   * @param string          $name
   * @param LoggerInterface $logger
   *
   * @return fwLoggerCollection
   */
  public function add($name, LoggerInterface $logger)
  {
    $this->loggers[$name] = $logger;

    return $this;
  }

  /**
   * @param string $name
   *
   * @return LoggerInterface
   */
  public function get($name)
  {
    return $this->loggers[$name];
  }

  /**
   * @return LoggerInterface[]
   */
  public function all()
  {
    return $this->loggers;
  }

  /**
   * @return int
   */
  public function count()
  {
    return count($this->loggers);
  }
}
