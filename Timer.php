<?php
class Timer
{
  private $bot;

  /**
    * @param string $token
    * @param string $auth
    */
  public function __construct($token, $auth)
  {
    $this->bot = new StreamElements($token, $auth);
  }

  /**
    * @param array $params
    * @return null|mixed
    */
  public function createTimer($params)
  {
    $name = $params[0];

    $online = false;
    $onlineInt = 1;
    if ($params[1] != 0)
    {
      $online = true;
      $onlineInt = $params[1];
    }

    $offline = false;
    $offlineInt = 1;
    if ($params[2] != 0)
    {
      $offline = true;
      $offlineInt = $params[2];
    }

    $chatLines = $params[3];

    $messages = array();
    for ($i = 4; $i < count($params); $i++)
    {
      array_push($messages, $params[$i]);
    }
    return $this->bot->createTimer($name, $messages, $chatLines, $online, $onlineInt, $offline, $offlineInt);
  }

  /**
    * @param string $timerName
    * @return null|mixed
    */
  public function getTimer($timerName)
  {
    $timers = $this->bot->listTimers();

    foreach ($timers as $key => $timer)
    {
      if (mb_strtolower($timer["name"]) == mb_strtolower($timerName))
        return $timer;
    }
    return null;
  }

  /**
    * @param string $timerName
    * @param array $params
    */
  public function updateTimer($params)
  {
    $timer = $this->getTimer($params[0]);
    $timerId = $timer["_id"];
    $name = $timer["name"];
    $enabled = $timer["enabled"];

    $online = false;
    $onlineInt = 1;
    if ($params[1] != 0)
    {
      $online = true;
      $onlineInt = $params[1];
    }

    $offline = false;
    $offlineInt = 1;
    if ($params[2] != 0)
    {
      $offline = true;
      $offlineInt = $params[2];
    }

    $chatLines = $params[3];

    $messages = array();
    for ($i = 4; $i < count($params); $i++)
    {
      array_push($messages, $params[$i]);
    }
    return $this->bot->updateTimer($timerId, $name, $messages, $chatLines, $enabled, $online, $onlineInt, $offline, $offlineInt);
  }


  /**
    * @param string $timerName
    * @param bool $enable
    * @return null|mixed
    */
  public function toggleTimer($timerName, $enabled)
  {
    $timer = $this->getTimer($timerName);
    return $this->bot->updateTimer(
      $timer["_id"],
      $timer["name"],
      $timer["messages"],
      $timer["chatLines"],
      $enabled,
      $timer["online"]["enabled"],
      $timer["online"]["interval"],
      $timer["offline"]["enabled"],
      $timer["offline"]["interval"]
    );
  }

  /**
    * @param string $timerName
    * @return null|mixed
    */
  public function deleteTimer($timerName)
  {
    $timer = $this->getTimer($timerName);

    return $this->bot->deleteTimer($timer["_id"]);
  }

  /**
    * @param string $timerName
    * @return string
    */
  public function toString($timerName)
  {
    $timer = $this->getTimer($timerName);

    if ($timer !== null)
    {
      $res = "Timer name: ".$timer["name"]." | Messages: ";
      foreach ($timer["messages"] as $key => $message)
      {
        $res .= $key + 1 .": \"".$message."\" | ";
      }
      return $res;
    }
    return "";
  }
}