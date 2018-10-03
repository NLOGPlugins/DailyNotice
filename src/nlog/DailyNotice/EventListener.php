<?php
/**
 * Created by PhpStorm.
 * User: nlog
 * Date: 2018-10-03
 * Time: 오전 8:51
 */

namespace nlog\DailyNotice;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\network\mcpe\protocol\SetLocalPlayerAsInitializedPacket;

class EventListener implements Listener {

    private const FORM_ID = 828291;

    /** @var DailyNotice */
    private $plugin;

    public function __construct(DailyNotice $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * @return DailyNotice
     */
    public function getPlugin(): DailyNotice {
        return $this->plugin;
    }

    public function onPlayerJoin(DataPacketReceiveEvent $ev) {
        if (($packet = $ev->getPacket()) instanceof SetLocalPlayerAsInitializedPacket) {
            if (($this->plugin->players[$ev->getPlayer()->getName()] ?? (time() - 1)) < time()) {
                $json = [];
                $json["type"] = "modal";
                $json["title"] = $this->plugin->getSetting()->getTitle($ev->getPlayer());
                $json["content"] = $this->plugin->getSetting()->getMessage($ev->getPlayer());
                $json["button1"] = ">> 하루 동안 열지 않기 <<"; //true
                $json["button2"] = ">> 닫기 <<"; //false: ESC Key

                $pk = new ModalFormRequestPacket();
                $pk->formId = self::FORM_ID;
                $pk->formData = json_encode($json);

                $ev->getPlayer()->sendDataPacket($pk);
            }
        } elseif ($packet instanceof ModalFormResponsePacket && $packet->formId === self::FORM_ID) {
            $res = trim($packet->formData);
            if (strpos($res, "null") === false) {
                if ($res === "true") {
                    $this->plugin->players[$ev->getPlayer()->getName()] = strtotime('tomorrow');
                    $ev->getPlayer()->sendMessage("§b§l[알림] §r§7하루 동안 공지창을 열지 않습니다.");
                }
            }

        }
    }
}