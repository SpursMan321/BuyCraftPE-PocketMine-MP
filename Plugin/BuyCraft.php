<?php

/*
__PocketMine Plugin__
name=BuyCraftPE
description=Create a server shop and obtain donations!
version=1.0.0dev
author=BuyCraftPE
class=BuyCraft
apiversion=11,12
*/

class BuyCraft implements Plugin
{
    private $api;

    public function __construct(ServerAPI $api, $server = false)
    {
        $this->api = $api;
    }

    public function init()
    {
            $this->config = new Config($this->api->plugin->configPath($this)."config.yml", CONFIG_YAML, array(
                "Key" => 000000,
            ));

            $this->api->console->register("buycraft", "<KEY|BUY>", array($this, "CommandHandler"));

            $this->api->console->alias("bc","buycraft");

            $this->api->ban->cmdWhitelist("buycraft");

            $this->config = $this->api->plugin->readYAML($this->api->plugin->configPath($this) . "config.yml");

                console("[INFO] [BuyCraftPE] Checking BuyCraftPE Server Status...");
                    $buyLoop = new buyLoop($this->config["Key"]);
                        if($buyLoop){
                            console("[INFO] BuyCraftPE Server Status: OK");
                            console("[INFO] BuyCraftPE Loaded!");
                               }
               else console("[WARNING] Could not connect to BuyCraftPE Service!");
    }

    public function CommandHandler($cmd, $params, $issuer, $alias)
    {
        switch(strtolower($cmd))
        {
            case "buycraft":

                 if($params[0] == "help"){

                     return "Usage: /BuyCraft <KEY|BUY>";

                         }elseif($params[0] == "key"){

                             if($this->api->ban->isOP($issuer) || !($issuer instanceof Player)){
                                 if(isset($params[1])){

                                     $this->config["Key"] = $params[1];
                         
                                     $this->api->plugin->writeYAML($this->api->plugin->configPath($this) . "config.yml", $this->config);
                                     $this->config = $this->api->plugin->readYAML($this->api->plugin->configPath($this) . "config.yml");
                                     return "[BuyCraftPE] Your BuyCrafPEt KEY has been updated!";

                                         }else{

                                             return "Usage: /BuyCraft key <KEY>";

                                         }
                                                 }else{
                                                     return "[BuyCraftPE] You must be an operator or on the console to change the BuyCraftPE KEY!";
                                                         }elseif($params[0] == "buy"){
                                                             if(isset($params[1])){
                                                                 //Code to gather Items goes here!
                                                                 $itemid = strtoupper($params[1]);

                                                                 return "[BuyCraftPE] This feature will be available in a later BuyCraftPE Update!";

                                                                 }
                                                                     }else{

                                                                         return "Usage: /BuyCraft buy <ID>";

                    }
            break;
        }
    }

    public function __destruct()
    {
        console("[INFO] BuyCraftPE Unloaded!");
    }
}
class buyLoop extends Thread{
	public $b;
	//private $auth;
	public $stop;
        public $key;
	public function __construct($k){
		$this->b = array();
		$this->stop = false;
		$this->start();
                $this->key = $k;
                return $this->establishConnection();
	}

	public function stop(){
		$this->stop = true;
		return $b;

	}
	public function run(){
		while($this->stop === false){

		
		}
exit(0);
	}
public function establishConnection(){
//Handshake with service and send secret, ensure validitity 
return false;
}
}
