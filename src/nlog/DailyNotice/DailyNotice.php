<?php

namespace nlog\DailyNotice;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

class DailyNotice extends PluginBase implements Listener {

    /** @var null|Setting */
    private static $setting = null;

    /**
     * @return Setting|null
     */
    public static function getSetting(): ?Setting {
        return self::$setting;
    }

    /** @var array */
    public $players;

    public function onLoad() {
        date_default_timezone_set("Asia/Seoul");
    }

    public function onEnable() {
        self::$setting = new Setting($this->getDataFolder() . "setting.yml");
        $this->players = (new Config($this->getDataFolder() . "data.json", Config::JSON))->getAll();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    public function onDisable() {
        $c = new Config($this->getDataFolder() . "data.json", Config::JSON);
        $c->setAll($this->players);
        $c->save();
    }

}

