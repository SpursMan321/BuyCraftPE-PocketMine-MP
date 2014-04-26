<?php

/*
__PocketMine Plugin__
name=BuyCraftPE
description=Create a server shop and obtain donations!
version=1.0.0dev
author=BuyCraftPE Team
class=BuyCraft
apiversion=11,12
*/

class BuyCraft implements Plugin{
  private $api;

  public function __construct(ServerAPI $api, $server = false)
  {
    $this->api = $api;
    define("BASE_URL","http://BuyCraftPE.net")
  }

  public function init()
  {
    $this->config = new Config($this->api->plugin->configPath($this)."config.yml", CONFIG_YAML, array(
    "Key" => 000000, 
    "Secret" => 000000
    ));
    $this->config = $this->api->plugin->readYAML($this->api->plugin->configPath($this) . "config.yml");
    console("[INFO] [BuyCraftPE] Checking BuyCraftPE Server Status...");
    $this->buyLoop = new buyLoop($this->config["Key"],$this->config["Secret"]);
    if ($this->buyLoop) {
      console("[INFO] BuyCraftPE Server Status: " . FORMAT_GREEN . "OK");
      console("[INFO] Continuing To Load BuyCraftPE...");

      $this->api->console->register("buycraft", "<LOGIN|BUY>", array($this, "CommandHandler"));
      $this->api->console->alias("bc", "buycraft");
      $this->api->ban->cmdWhitelist("buycraft");

      console("[INFO] BuyCraftPE Loaded!");

    }else{
        console("[WARNING] BuyCraftPE Server Status: " . FORMAT_RED . "Unavailable");
        console("[WARNING] BuyCraftPE Could NOT Load As The Service Is Unavailable!");
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
            return "[BuyCraftPE] Your BuyCraftPE Details has been updated! Restart the server to see changes.";
          }
          else  return "Usage: /BuyCraft login <KEY> <SECRET>";
        }
        else return "[BuyCraftPE] You must be an operator or on the console to change the BuyCraftPE Details!";
      }
      elseif($params[0] == "buy") {
        if (isset($params[1])) {
          //Code to gather Items goes here!
          $itemid = strtoupper($params[1]);
          return "[BuyCraftPE] This feature will be available in a later BuyCraftPE Update!";
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
  public function __construct($k,$s) {
    $this->b = array();
    $this->stop = false;
    $this->s = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_bind($this->s, 0.0.0.0, 18656);
    socket_set_option($this->s, SOL_SOCKET, SO_REUSEADDR, 1);
    socket_listen($this->s, 5);
    $this->start();
    $this->key = $k;
    $this->s = $s;
    $this->ip =
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
  $con = socket_accept($this->s);
if(socket_getpeername($con) == gethostbyname(BASE_URL)) //Check that connection is from interface
$b[] = decrypt(trim(socket_read($con, 2048, PHP_NORMAL_READ))));
  socket_close($con);
    
   
    }
    socket_close($this->s);
    exit(0);
  }
  public function establishConnection() {
  if(file_get_contents(BASE_URL . "/api/init.php?key=" . $this->key . "&secret=" . encrypt(($this->ip = Utils::getIP(true))))) !== false) return true;
    return false;
    $this->stop = true:
  }
  public function encrypt($str){
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->s), $str, MCRYPT_MODE_CBC, md5(md5($this->s)))), true, 301);
  }
  public function decrypt($str){
   return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->s), base64_decode($str), MCRYPT_MODE_CBC, md5(md5($this->s))), "\0");
  }
}
