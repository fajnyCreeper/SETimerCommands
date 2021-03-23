<?php
function CreateTimer($bot, $params)
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
  return $bot->createTimer($name, $messages, $chatLines, $online, $onlineInt, $offline, $offlineInt);
}
