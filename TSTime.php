<?php

require_once("TeamSpeak3/TeamSpeak3.php");
date_default_timezone_set('America/Argentina/Buenos_Aires');
TeamSpeak3::init();

$user = "serveradmin";
$pass = "mc4zYL9G";
$serverIP = "127.0.0.1";
$botTimeChannel = 2;
$botUsersChannel = 3;
$nickname = "TimeBot";

try
{
	$ts3 = TeamSpeak3::factory("serverquery://{$user}:{$pass}@{$serverIP}:10011/?server_port=9987&blocking=0&nickname={$nickname}");

    $BotChannelTime = $ts3->channelGetById($botTimeChannel);
    $BotChannelUsuarios = $ts3->channelGetById($botUsersChannel);

    $unixTime = time();
	$realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    echo $realTime."\t[INFO] Connected\n";

	$unixTime = time();
    $realTime = date('[Y-m-d] - [H:i]',$unixTime);
    if($BotChannelTime["channel_name"] != "[cspacer0] {$realTime}")
    {
        $BotChannelTime["channel_name"] = "[cspacer0] {$realTime}";
        $unixTime = time();
        $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
        echo $realTime."\t[INFO] Time updated\n";
    }

    $serverInfo = $ts3->getInfo();
    $maxSlots = $serverInfo["virtualserver_maxclients"];
    $clientsOnline = $serverInfo["virtualserver_clientsonline"];
    $slotsReserved = $serverInfo["virtualserver_reserved_slots"];
    $slotsAvailable = $maxSlots - $slotsReserved;

    if($BotChannelUsuarios["channel_name"] != "[cspacer0] Users online: {$clientsOnline}/{$slotsAvailable}")
    {
        $BotChannelUsuarios["channel_name"] = "[cspacer0] Users online: {$clientsOnline}/{$slotsAvailable}";
        $unixTime = time();
        $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
        echo $realTime."\t[INFO] Users online updated\n";
    }

    $unixTime = time();
    $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    die($realTime."\t[INFO] Finished.\n");
}
catch(Exception $e)
{
    $unixTime = time();
    $realTime = date('[Y-m-d] [H:i:s]',$unixTime);
    echo "Failed\n";
    die($realTime."\t[ERROR]  " . $e->getMessage() . "\n". $e->getTraceAsString() ."\n");
}
