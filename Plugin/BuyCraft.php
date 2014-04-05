<?php

/*
__PocketMine Plugin__
name=BuyCraftPE
description=Create a server shop and obtain donations!
version=0.5.0
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

        $this->config = $this->api->plugin->readYAML($this->api->plugin->configPath($this) . "config.yml");

            console("[INFO] BuyCraftPE Loaded!");
    }

    public function CommandHandler($cmd, $params, $issuer, $alias)
    {
        switch(strtolower($cmd))
        {
            case "buycraft":

                 if($params[0] == "help"){

                     return "Usage: /BuyCraft <KEY|BUY>";

                     }elseif($params[0] == "key"){

                         if(isset($params[1])){

                             $this->config["Key"] = $params[1];
                         
                             $this->api->plugin->writeYAML($this->api->plugin->configPath($this) . "config.yml", $this->config);
                             $this->config = $this->api->plugin->readYAML($this->api->plugin->configPath($this) . "config.yml");
                             return "[BuyCraftPE] Your BuyCrafPEt KEY has been saved!";

                         }else{

                             return "Usage: /BuyCraft key <KEY>";

                         }
                     }elseif($params[0] == "buy"){
                         if(isset($params[1])){
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

?>
