<?php
/*
   _____  .__                .___  __          ____  ________
  /  _  \ |  |   ____ ___  __|   |/  |________/_   |/  _____/
 /  /_\  \|  | _/ __ \\  \/  /   \   __\___   /|   /   __  \ 
/    |    \  |_\  ___/ >    <|   ||  |  /    / |   \  |__\  \
\____|__  /____/\___  >__/\_ \___||__| /_____ \|___|\_____  /
        \/          \/      \/               \/           \/ 
*/

namespace ItemText;

use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat as Color;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\event\entity\ItemSpawnEvent;
use pocketmine\entity\Entity;




class Main extends PluginBase implements Listener
{
	
	private $langTexts = [];
	private $cfg;


    public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		$pathLang = $this->getDataFolder() . "lang";
        //Save default lang files on first load
		@mkdir($pathLang);
        foreach ($this->getResources() as $resource) {
            $this->saveResource("lang" . DIRECTORY_SEPARATOR . $resource->getFilename());
		}
		
		$this->saveResource("config.yml");
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
		$this->cfg = $this->cfg->getAll();
		
		//Load Translation file
		$this->loadLang();
		
	}
    
    public function onItemSpawn(ItemSpawnEvent $e){
        $entity = $e->getEntity();
        $item = $entity->getItem();
        $name = $item->getName();
		
		$reversedName = array_search($name, $this->langTexts["en_US"]);
		if ($reversedName) {
			$entity->setNameTag($this->langTexts[$this->cfg["language"]][$reversedName]);
		}
		else	$entity->setNameTag($name);

        $entity->setNameTagVisible(true);
        $entity->setNameTagAlwaysVisible(true);
    }
	
	public function loadLang(){
		foreach ($this->getResources() as $resource) {
			$filename = $resource->getFilename();
			//check if it's an language file with correct name
			if(pathinfo($filename, PATHINFO_EXTENSION) == "lang" && preg_match('/[A-z]{2}_[A-z]{2}/', basename($filename, ".lang"))) {
				$localName = basename($filename, ".lang");
				$this->langTexts[$localName] = [];
				$texts = explode("\n", str_replace(["\r", "\\/\\/"], ["", "//"], file_get_contents($this->getDataFolder() . "lang" . DIRECTORY_SEPARATOR . $filename)));
				foreach($texts as $line){
					$line = trim($line);
					if($line === ""){
						continue;
					}
					$line = explode("=", $line);
					$this->langTexts[$localName][trim(array_shift($line))] = trim(str_replace(["\\n", "\\N",], "\n", implode("=", $line)));
				}
			}
		}
	}
	
	public function array_find($needle, array $haystack)
	{
		foreach ($haystack as $key => $value) {
			if (false !== stripos($value, $needle)) {
				return $key;
			}
		}
		return false;
	}

	

}