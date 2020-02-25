<?php
/*
  _____ _          ____            _    _    _           
 |_   _| |__   ___|  _ \ ___  __ _| |  / \  | | _____  __
   | | | '_ \ / _ \ |_) / _ \/ _` | | / _ \ | |/ _ \ \/ /
   | | | | | |  __/  _ <  __/ (_| | |/ ___ \| |  __/>  < 
   |_| |_| |_|\___|_| \_\___|\__,_|_/_/   \_\_|\___/_/\_\
                                                         
*/

namespace ItemText;

//Plugin
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;

//Utils
use pocketmine\utils\TextFormat;

//Event
use pocketmine\event\Listener;
use pocketmine\event\entity\ItemSpawnEvent;

//Server
use pocketmine\Server;

//Item
use pocketmine\item\Item;

//Entity
use pocketmine\entity\Entity;


class Main extends PluginBase implements Listener
{

    public function onEnable() {
	$this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->notice(TextFormat::LIGHT_PURPLE."ItemDisplayText Enabled");
        //Config soon!!!!!
    }
    
    public function onDisable() {
        $this->getLogger()->notice(TextFormat::LIGHT_PURPLE."ItemDisplayText Disabled!");
    }

    public function onThrow(ItemSpawnEvent $event){
        //Soon perWorld config!!!
        $player = $event->getPlayer();
        $name = $player->getName();
       
        $entity = $e->getEntity();
        $item = $entity->getItem();
        $itemname = $item->getName();
        $entity->setNameTag(TextFormat::LIGHT_PURPLE.$itemname);
        $entity->setNameTagVisible(true);
        $entity->setNameTagAlwaysVisible(true);
        //Message onThrow
        #$player->sendMessage(TextFormat::GRAY."You threw "TextFormat::LIGHT_PURPLE. $itemname);
    }

    
}
