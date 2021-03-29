<?php
class Timer
{
  private $bot;
  private $baseUrl;
  private $key;

  /**
    * @param string $token
    * @param string $auth
    */
  public function __construct($token, $auth, $baseUrl, $key)
  {
    $this->bot = new StreamElements($token, $auth);
    $this->baseUrl = $baseUrl;
    $this->key = $key;
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

    $res = $this->bot->createTimer($name, $messages, $chatLines, $online, $onlineInt, $offline, $offlineInt);

    if (array_key_exists("error", $res))
      return array("error" => $res["message"]);

    return $res;
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
    if ($timer !== null)
    {
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
    return null;
  }


  /**
    * @param string $timerName
    * @param bool $enable
    * @return null|mixed
    */
  public function toggleTimer($timerName, $enabled)
  {
    $timer = $this->getTimer($timerName);
    if ($timer !== null)
    {
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
    return null;
  }

  /**
    * @param string $timerName
    * @return null|mixed
    */
  public function deleteTimer($timerName)
  {
    $timer = $this->getTimer($timerName);

    if ($timer !== null)
      return $this->bot->deleteTimer($timer["_id"]);
    return null;
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
      $matches;
      foreach ($timer["messages"] as $key => $message)
      {
        if (preg_match("/\\\$\{customapi\..*\\/command.php\\?key=.*&command=(.*)\\}/", $message, $matches))
          $res .= $key + 1 .": Bound to command \"".$this->bot->getCommand($matches[1])["command"]."\"";
        else
          $res .= $key + 1 .": \"".$message."\" | ";
      }
      return $res;
    }
    return "";
  }

  /**
    * @return string
    */
  public function listTimers()
  {
    $timers = $this->bot->listTimers();
    $res = "Listing all timers: ";
    if ($timers !== null)
    {
      foreach ($timers as $timer)
      {
        $res .= "\"".$timer["name"]."\" | ";
      }
    }
    else
      $res = "No timers.";

    return $res;
  }

  public function bindCommand($timerName, $commandName)
  {
    $timer = $this->getTimer($timerName);
    $commandId = null;
    $commandList = $this->bot->listCommands();
    foreach ($commandList as $command)
    {
      if ($command["command"] == $commandName)
      {
        $commandId = $command["_id"];
        break;
      }
    }

    if ($timer !== null && $commandId !== null)
    {
      $message = "\${customapi.{$this->baseUrl}/command.php?key={$this->key}&command={$commandId}}";
      return $this->bot->updateTimer(
        $timer["_id"],
        $timer["name"],
        array($message),
        $timer["chatLines"],
        true,
        $timer["online"]["enabled"],
        $timer["online"]["interval"],
        $timer["offline"]["enabled"],
        $timer["offline"]["interval"]
      );
    }

    return null;
  }
}
