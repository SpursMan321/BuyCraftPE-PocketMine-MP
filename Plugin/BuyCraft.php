<?php

/*
__PocketMine Plugin__
name=BuyCraftPE
description=Create a server shop and obtain donations!
version=1.0.0dev-build_33
author=BuyCraftPE Team
class=BuyCraft
apiversion=11,12
*/

class BuyCraft implements Plugin{
  private $api;

  public function __construct(ServerAPI $api, $server = false)
  {
    $this->api = $api;
    define("BASE_URL","https://BuyCraftPE.net");
  }

  public function init()
  {
    $this->config = new Config($this->api->plugin->configPath($this)."config.yml", CONFIG_YAML, array(
    "Key" => 000000, 
    "Secret" => 000000,
    "WebstoreURL" => "https://ServerName.BuyCraftPE.net/"
    ));
    $this->config = $this->api->plugin->readYAML($this->api->plugin->configPath($this) . "config.yml");
    console("[INFO] Checking BuyCraftPE Server Status And Login Credentials...");
    $this->buyLoop = new buyLoop($this->config["Key"],$this->config["Secret"]);
    if ($this->buyLoop) {
      console("[INFO] BuyCraftPE Server Status: " . FORMAT_GREEN . "OK");
      console("[INFO] Loading BuyCraftPE...");

      $this->api->console->register("buycraft", "<LOGIN|BUY>", array($this, "CommandHandler"));
      $this->api->ban->cmdWhitelist("buycraft");
      $this->api->console->alias("bc", "buycraft");

      console("[INFO] BuyCraftPE Loaded!");

    }else{
        console("[WARNING] BuyCraftPE Server Status: " . FORMAT_RED . "Unavailable");
        console("[WARNING] Unable to load BuyCraftPE as the server is unavailable or your login details are incorrect.");
    }
  }

  public function CommandHandler($cmd, $params, $issuer, $alias)
  {
   $params[0] = strtolower($params[0]); //Switch param back to lower case
    switch(strtolower($cmd))
    {
      case "buycraft":
      if ($params[0] == "login") {

        if ($this->api->ban->isOP($issuer) || !($issuer instanceof Player)) {
          if (isset($params[2])) {

            $this->config["Key"] = $params[1];
            $this->config["Secret"] = $params[2];
            $this->api->plugin->writeYAML($this->api->plugin->configPath($this) . "config.yml", $this->config);
            $this->config = $this->api->plugin->readYAML($this->api->plugin->configPath($this) . "config.yml");
            return "[BuyCraftPE] Your BuyCraftPE Details have been updated! Restart the server to see changes.";
          }
          else  return "Usage: /BuyCraft login <KEY> <SECRET>";
        }
        else return "[BuyCraftPE] You must be an operator or on the console to change the BuyCraftPE Details!";
      }
      elseif($params[0] == "buy") {
        if (isset($params[1])) {
          //Code to gather Items goes here!
          $itemid = strtoupper($params[1]);
          return "[BuyCraftPE] To purchase items for this server, please visit: " . $this->config["WebstoreURL"];
        }
      }
      else return "Usage: /BuyCraft buy <ID>";
      break;
    }
  }

  public function __destruct()
  {
    console("[INFO] BuyCraftPE Unloaded!");
    $this->buyLoop.stop();
  }
}
class buyLoop extends Thread {
  public $b;
  public $stop;
  public $key;
  private $ip;
  private $s;
  private $sock;
  public function __construct($k,$s) {
    $this->b = array();
    $this->stop = false;
    $this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_bind($this->sock, "0.0.0.0", 18656);
    socket_set_option($this->sock, SOL_SOCKET, SO_REUSEADDR, 1);
    socket_listen($this->sock, 5);
    $this->ip = Utils::getIP(true);
    $this->start();
    $this->key = $k;
    $this->s = $s;
    return $this->establishConnection();
  }

  public function stop() {
    $this->stop = true;
    return $b;
  }
  public function run() {
    while ($this->stop === false) {
    if($this->ip !== Utils::getIP(true)){
     console("[ERROR] BuyCraftPE doesn't like Dynamic IP's and can't yet bind to them.");
      $this->stop();
    }
    else $this->ip = Utils::getIP();
  $con = socket_accept($this->sock);
  if(socket_getpeername($con) == gethostbyname(BASE_URL)) $b[] = $this->decrypt(trim(socket_read($con, 2048, PHP_NORMAL_READ)));
  socket_close($con);
    }
    socket_close($this->sock);
    exit(0);
  }
  public function establishConnection() {
  if(Utils::curl_get(BASE_URL . "/api/init.php?key=" . $this->key . "&secret=" . $this->s) !== false) return true;
    return false;
    $this->stop = true;
  }
  public function decrypt($str){
    //Decrypt string using secret
    return $str;
  }
}
