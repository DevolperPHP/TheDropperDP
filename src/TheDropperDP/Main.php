<?php

namespace TheDropperDP;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\PluginTask;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerDropItem;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\IPlayer;
use pocketmine\plugin\Plugin;
use pocketmine\tile\Chest;
use pocketmine\event\entity;
use pocketmine\level\Location;
use pocketmine\item\Item;
use pocketmine\inventory\BaseInventory;
use pocketmine\inventory\PlayerInventory;
use pocketmine\inventory\ChestInventory;
use pocketmine\inventory\CustomInventory;
use pocketmine\inventory\InventoryType;
use pocketmine\entity\Effect;
use pocketmine\math\Vector3;
use pocketmine\tile\Sign;
use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener{

    public $prefix = "§cThe§bDropper";

    public $minutelobby = 0;
    public $secondlobby = 10;
    public $counttypelobby = "down";
    public $enabletimelobby = true;

    public $minuteendgame = 7;
    public $secondendgame = 30;
    public $counttypeendgame = "down";
    public $enabletimegame = true;


    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new Task($this),20);
        $this->getLogger()->info("$this->prefix §bis §6Enable.");
        @mkdir($this->getDataFolder());
        $info = [

            'map1' => 'world',
            'x1' => '0',
            'y1' => '0',
            'z1' => '0',
            'map2' => 'world',
            'x2' => '0',
            'y2' => '0',
            'z2' => '0',
            'map3' => 'world',
            'x3' => '0',
            'y3' => '0',
            'z3' => '0',
            'map4' => 'world',
            'x4' => '0',
            'y4' => '0',
            'z4' => '0',
            'map5' => 'world',
            'x5' => '0',
            'y5' => '0',
            'z5' => '0',
            'lobby' => 'world',
            'xlobby' => '0',
            'ylobby' => '0',
            'zlobby' => '0',
            'leave' => 'world',
            'xleave' => '0',
            'yleave' => '0',
            'zleave' => '0',
            'line1' => '[§cThe§bDropperDP]',
            'line2' => '§6Join §eThe §bGame',
            'line3' => '§cLobby',
            'line4' => '§bDeveloper§cPHP §9Team',
            'line11' => '§cMap §b2',
            'line21' => '§aFiensh §5Map §61',
            'line31' => '§eTeleport §bMap §b2',
            'line41' => '§bDeveloper§cPHP §9Team',
            'line12' => '§cMap §b3',
            'line22' => '§aFiensh §5Map §2',
            'line32' => '§eTeleport §bMap §b3',
            'line42' => '§bDeveloper§cPHP §9Team',
            'line13' => '§cMap §b4',
            'line23' => '§aFiensh §5Map §3',
            'line33' => '§eTeleport §bMap §b4',
            'line43' => '§bDeveloper§cPHP §9Team',
            'line14' => '§cMap §b5',
            'line24' => '§aFiensh §5Map §4',
            'line34' => '§eTeleport §bMap §b4',
            'line44' => '§bDeveloper§cPHP §9Team',
            'line15' => '§cComplete §bMaps',
            'line25' => '§aFiensh §5Map §5',
            'line35' => '§eTeleport §bMap §bComplete',
            'line45' => '§bDeveloper§cPHP §9Team',

        ];
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML, $info);
        $cfg->save();
    }

    public function onDisable(){
        $this->getConfig()->save();
    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
        if($sender->isOp()) {
            switch ($cmd->getName()) {
                case 'td':

                    if (isset($args[0])) {
                        switch ($args[0]) {

                            case 'setlobby':
                                $xlobby = $sender->getFloorX();
                                $ylobby = $sender->getFloorY();
                                $zlobby = $sender->getFloorZ();

                                $this->getConfig()->set("xlobby", $xlobby);
                                $this->getConfig()->set("ylobby", $ylobby);
                                $this->getConfig()->set("zlobby", $zlobby);

                                $world = $sender->getLevel()->getName();
                                $this->getConfig()->set("lobby", $world);

                                $sender->sendMessage("[$this->prefix]§a Complete, World name [$world] xyz: $xlobby, $ylobby, $zlobby");

                                return true;

                            case 'setmap':

                                if (isset($args[1])) {
                                    switch ($args[1]) {

                                        case '1':

                                            $xmap1 = $sender->getFloorX();
                                            $ymap1 = $sender->getFloorY();
                                            $zmap1 = $sender->getFloorZ();

                                            $this->getConfig()->set("x1", $xmap1);
                                            $this->getConfig()->set("y1", $ymap1);
                                            $this->getConfig()->set("z1", $zmap1);

                                            $map1 = $sender->getLevel()->getName();
                                            $this->getConfig()->set("map1", $map1);

                                            $sender->sendMessage("[$this->prefix]§a Complete,§e map 1 §6[$map1] §exyz §6: $xmap1, $ymap1, $zmap1");

                                            return true;

                                        case '2':
                                            $xmap2 = $sender->getFloorX();
                                            $ymap2 = $sender->getFloorY();
                                            $zmap2 = $sender->getFloorZ();

                                            $this->getConfig()->set("x2", $xmap2);
                                            $this->getConfig()->set("y2", $ymap2);
                                            $this->getConfig()->set("z2", $zmap2);

                                            $map2 = $sender->getLevel()->getName();
                                            $this->getConfig()->set("map2", $map2);

                                            $sender->sendMessage("[$this->prefix]§a Complete,§e map 2 §6[$map2] §exyz §6: $xmap2, $ymap2, $zmap2");

                                            return true;

                                        case '3':
                                            $xmap3 = $sender->getFloorX();
                                            $ymap3 = $sender->getFloorY();
                                            $zmap3 = $sender->getFloorZ();

                                            $this->getConfig()->set("x3", $xmap3);
                                            $this->getConfig()->set("y3", $ymap3);
                                            $this->getConfig()->set("z3", $zmap3);

                                            $map3 = $sender->getLevel()->getName();
                                            $this->getConfig()->set("map3", $map3);

                                            $sender->sendMessage("[$this->prefix]§a Complete,§e map 1 §6[$map3] §exyz §6: $xmap3, $ymap3, $zmap3");

                                            return true;

                                        case '4':
                                            $xmap4 = $sender->getFloorX();
                                            $ymap4 = $sender->getFloorY();
                                            $zmap4 = $sender->getFloorZ();

                                            $this->getConfig()->set("x4", $xmap4);
                                            $this->getConfig()->set("y4", $ymap4);
                                            $this->getConfig()->set("z4", $zmap4);

                                            $map4 = $sender->getLevel()->getName();
                                            $this->getConfig()->set("map4", $map4);

                                            $sender->sendMessage("[$this->prefix]§a Complete,§e map 4 §6[$map4] §exyz §6: $xmap4, $ymap4, $zmap4");

                                            return true;

                                        case '5':
                                            $xmap5 = $sender->getFloorX();
                                            $ymap5 = $sender->getFloorY();
                                            $zmap5 = $sender->getFloorZ();

                                            $this->getConfig()->set("x5", $xmap5);
                                            $this->getConfig()->set("y5", $ymap5);
                                            $this->getConfig()->set("z5", $zmap5);

                                            $map5 = $sender->getLevel()->getName();
                                            $this->getConfig()->set("map5", $map5);

                                            $sender->sendMessage("[$this->prefix]§a Complete,§e map 5 §6[$map5] §exyz §6: $xmap5, $ymap5, $zmap5");
                                    }

                                }

                            case 'setleave':
                                $xleave = $sender->getFloorX();
                                $yleave = $sender->getFloorY();
                                $zleave = $sender->getFloorZ();

                                $this->getConfig()->set("xleave", $xleave);
                                $this->getConfig()->set("yleave", $yleave);
                                $this->getConfig()->set("zleave", $zleave);

                                $leave = $sender->getLevel()->getName();
                                $this->getConfig()->set("map5", $leave);

                                $sender->sendMessage("[$this->prefix]§a Complete,§e Leave area §6[$leave] §exyz §6: $leave, $leave, $zleave");

                                return true;

                            case 'help':
                                $sender->sendMessage("]=======[$this->prefix]=======[");
                                $sender->sendMessage("§6/§btd §asetlobby §e: §cUse command to set lobby location");
                                $sender->sendMessage("§6/§btd §asetleave §e: §cUse command to set leave location");
                                $sender->sendMessage("§6/§btd §asetmap1 §e: §cUse command to set map1 location");
                                $sender->sendMessage("§6/§btd §asetmap2 §e: §cUse command to set map2 location");
                                $sender->sendMessage("§6/§btd §asetmap3 - 4 - 5 §e: §cUse command to set map location");
                                $sender->sendMessage("]=======[$this->prefix]=======[");

                                return true;

                            case 'leave':
                                $leave = $this->getConfig()->get("leave");
                                $xleave = $this->getConfig()->get("xleave");
                                $yleave = $this->getConfig()->get("yleave");
                                $zleave = $this->getConfig()->get("zleave");

                                $lvl = $this->getServer()->getLevelByName($leave);
                                $spawn = $lvl->getSafeSpawn();

                                $this->getServer()->loadLevel($leave);
                                $sender->teleport(new Position($spawn->getX(), $spawn->getY(), $spawn->getZ(), $lvl));
                                $sender->teleport(new Position($xleave, $yleave, $zleave));
                        }
                    }
            }
        }
    }

    public function tick(){
        $lobby = $this->getConfig()->get("lobby");
        $xlobby = $this->getConfig()->get("xlobby");
        $ylobby = $this->getConfig()->get("ylobby");
        $zlobby = $this->getConfig()->get("zlobby");
        $time = $this->getServer()->getLevelByName($lobby)->getPlayers();
        $lvl = $this->getServer()->getLevelByName($lobby);
        $spawn = $lvl->getSafeSpawn();
        $map1 = $this->getConfig()->get("map1");
        $map2 = $this->getConfig()->get("map2");
        $map3 = $this->getConfig()->get("map3");
        $map4 = $this->getConfig()->get("map4");
        $map5 = $this->getConfig()->get("map5");
        $leave = $this->getConfig()->get("leave");
        $xleave = $this->getConfig()->get("xleave");
        $yleave = $this->getConfig()->get("yleave");
        $zleave = $this->getConfig()->get("zleave");

        foreach($time as $p) {

            if ($this->enabletimelobby == true) {

                $this->secondlobby--;
            }

            if ($this->secondlobby >= 0 && $this->secondlobby >= 0) {

                $p->sendTip("[$this->prefix] §aTime :$this->minutelobby : $this->secondlobby");
            }

            if ($this->secondlobby == 0 && $this->minutelobby == 0) {
                $this->getServer()->loadLevel($lobby);
                $p->teleport(new Position($spawn->getX(), $spawn->getY(), $spawn->getZ(), $lvl));
                $p->teleport(new Position($xlobby, $ylobby, $zlobby));

                $this->enabletimelobby = false;
            }

            if ($this->enabletimelobby == true) {

                if ($this->secondlobby == 0) {

                    $this->secondlobby = 60;
                    $this->minutelobby--;
                }
            }
        }

        foreach($map1 && $map2 && $map3 && $map4 && $map5 as $game){

            if ($this->enabletimegame == true) {

                $this->secondendgame--;
            }

            if ($this->secondendgame >= 0 && $this->secondendgame >= 0) {

                $game->sendTip("[$this->prefix] §aTime :$this->minuteendgame : $this->secondendgame");
            }

            if ($this->secondendgame == 0 && $this->minuteendgame == 0) {
                $this->getServer()->loadLevel($leave);
                $p->teleport(new Position($spawn->getX(), $spawn->getY(), $spawn->getZ(), $lvl));
                $p->teleport(new Position($xleave, $yleave, $zleave));

                $this->enabletimegame = false;
            }

            if ($this->enabletimegame == true) {

                if ($this->secondendgame == 0) {

                    $this->secondendgame = 60;
                    $this->minuteendgame--;
                }
            }
        }
    }

    public function onChange(SignChangeEvent $e){

        $p = $e->getPlayer();
        $line1 = $this->getConfig()->get("line1");
        $line2 = $this->getConfig()->get("line2");
        $line3 = $this->getConfig()->get("line3");
        $line4 = $this->getConfig()->get("line4");

        $line11 = $this->getConfig()->get("line11");
        $line21 = $this->getConfig()->get("line21");
        $line31 = $this->getConfig()->get("line31");
        $line41 = $this->getConfig()->get("line41");

        $line12 = $this->getConfig()->get("line12");
        $line22 = $this->getConfig()->get("line22");
        $line32 = $this->getConfig()->get("line32");
        $line42 = $this->getConfig()->get("line42");

        $line13 = $this->getConfig()->get("line13");
        $line23 = $this->getConfig()->get("line23");
        $line33 = $this->getConfig()->get("line33");
        $line43 = $this->getConfig()->get("line43");

        $line14 = $this->getConfig()->get("line14");
        $line24 = $this->getConfig()->get("line24");
        $line34 = $this->getConfig()->get("line34");
        $line44 = $this->getConfig()->get("line44");

        $line15 = $this->getConfig()->get("line15");
        $line25 = $this->getConfig()->get("line25");
        $line35 = $this->getConfig()->get("line35");
        $line45 = $this->getConfig()->get("line45");

        if($p->isOp()) {
            if ($e->getLine(0) === "td") {
                $e->setLine(0, $line1);
                $e->setLine(1, $line2);
                $e->setLine(2, $line3);
                $e->setLine(3, $line4);
            }

            if ($e->getLine(0) === "td1") {
                $e->setLine(0, $line11);
                $e->setLine(1, $line21);
                $e->setLine(2, $line31);
                $e->setLine(3, $line41);
            }

            if ($e->getLine(0) === "td2") {
                $e->setLine(0, $line12);
                $e->setLine(1, $line22);
                $e->setLine(2, $line32);
                $e->setLine(3, $line42);
            }

            if ($e->getLine(0) === "td3") {
                $e->setLine(0, $line13);
                $e->setLine(1, $line23);
                $e->setLine(2, $line33);
                $e->setLine(3, $line43);
            }

            if ($e->getLine(0) === "td4") {
                $e->setLine(0, $line14);
                $e->setLine(1, $line24);
                $e->setLine(2, $line34);
                $e->setLine(3, $line44);
            }

            if ($e->getLine(0) === "td5") {
                $e->setLine(0, $line15);
                $e->setLine(1, $line25);
                $e->setLine(2, $line35);
                $e->setLine(3, $line45);
            }
        }
    }

    public function onClick(PlayerInteractEvent $e){
        $sign = $e->getBlock()->getLevel()->getTile($e->getBlock());
        $p = $e->getPlayer();
        $lobby = $this->getConfig()->get("lobby");
        $xlobby = $this->getConfig()->get("xlobby");
        $ylobby = $this->getConfig()->get("ylobby");
        $zlobby = $this->getConfig()->get("zlobby");
        $line1 = $this->getConfig()->get("line1");

        $leave = $this->getConfig()->get("leave");
        $xleave = $this->getConfig()->get("xleave");
        $yleave = $this->getConfig()->get("yleave");
        $zleave = $this->getConfig()->get("zleave");
        $linemap1 = $this->getConfig()->get("line11");

        $map2 = $this->getConfig()->get("map2");
        $xmap2 = $this->getConfig()->get("xmap2");
        $ymap2 = $this->getConfig()->get("ymap2");
        $zmap2 = $this->getConfig()->get("zmap2");
        $linemap2 = $this->getConfig()->get("line12");

        $map3 = $this->getConfig()->get("map3");
        $xmap3 = $this->getConfig()->get("xmap3");
        $ymap3 = $this->getConfig()->get("ymap3");
        $zmap3 = $this->getConfig()->get("zmap3");
        $linemap3 = $this->getConfig()->get("line13");

        $map4 = $this->getConfig()->get("map4");
        $xmap4 = $this->getConfig()->get("xmap4");
        $ymap4 = $this->getConfig()->get("ymap4");
        $zmap4 = $this->getConfig()->get("zmap4");
        $linemap4 = $this->getConfig()->get("line14");

        $map5 = $this->getConfig()->get("map5");
        $xmap5 = $this->getConfig()->get("xmap5");
        $ymap5 = $this->getConfig()->get("ymap5");
        $zmap5 = $this->getConfig()->get("zmap5");
        $linemap5 = $this->getConfig()->get("line15");

        $lvl = $this->getServer()->getLevelByName($lobby);
        $spawn = $lvl->getSafeSpawn();

        if($sign instanceof Sign){

            $text = $sign->getText();

            if($text[0] === $line1){

                $this->getServer()->loadLevel($lobby);
                $p->teleport(new Position($spawn->getX(), $spawn->getY(), $spawn->getZ(), $lvl));
                $p->teleport(new Position($xlobby, $ylobby, $zlobby));
                $p->sendMessage("[$this->prefix] §aWelcome §eTo §6Lobby");
                $this->enabletimelobby = true;
            }

            if($text[0] === $linemap1){

                if(!$this->getServer()->isLevelLoaded($map2)){
                    $this->getServer()->loadLevel($map2);
                }

                $p->teleport(new Vector3($xmap2, $ymap2, $zmap2, $map2));
                $p->sendMessage("[$this->prefix] §aWelcome §eTo §6Map2");
            }

            if($text[0] === $linemap2){

                if(!$this->getServer()->isLevelLoaded($map3)){
                    $this->getServer()->loadLevel($map3);
                }

                $p->teleport(new Vector3($xmap3, $ymap3, $zmap3, $map3));
                $p->sendMessage("[$this->prefix] §aWelcome §eTo §6Map3");
            }

            if($text[0] === $linemap3){

                if(!$this->getServer()->isLevelLoaded($map4)){
                    $this->getServer()->loadLevel($map4);
                }

                $p->teleport(new Vector3($xmap4, $ymap4, $zmap4, $map4));
                $p->sendMessage("[$this->prefix] §aWelcome §eTo §6Map4");
            }

            if($text[0] === $linemap4){

                if(!$this->getServer()->isLevelLoaded($map5)){
                    $this->getServer()->loadLevel($map5);
                }

                $p->teleport(new Vector3($xmap5, $ymap5, $zmap5, $map5));
                $p->sendMessage("[$this->prefix] §aWelcome §eTo §6Map5");
            }

            if($text[0] === $linemap5){

                if(!$this->getServer()->isLevelLoaded($leave)){
                    $this->getServer()->loadLevel($leave);
                }

                $p->teleport(new Vector3($xleave, $yleave, $zleave, $leave));
                $p->sendMessage("[$this->prefix] §6Tank §byou §6for §cplaying");
            }
        }
    }

    public function onDeath(PlayerDeathEvent $event){
        $player = $event->getPlayer();

        $map1 = $this->getConfig()->get("map1");
        $xmap1 = $this->getConfig()->get("xmap1");
        $ymap1 = $this->getConfig()->get("ymap1");
        $zmap1 = $this->getConfig()->get("zmap1");

        $map2 = $this->getConfig()->get("map2");
        $xmap2 = $this->getConfig()->get("xmap2");
        $ymap2 = $this->getConfig()->get("ymap2");
        $zmap2 = $this->getConfig()->get("zmap2");

        $map3 = $this->getConfig()->get("map3");
        $xmap3 = $this->getConfig()->get("xmap3");
        $ymap3 = $this->getConfig()->get("ymap3");
        $zmap3 = $this->getConfig()->get("zmap3");

        $map4 = $this->getConfig()->get("map4");
        $xmap4 = $this->getConfig()->get("xmap4");
        $ymap4 = $this->getConfig()->get("ymap4");
        $zmap4 = $this->getConfig()->get("zmap4");

        $map5 = $this->getConfig()->get("map5");
        $xmap5 = $this->getConfig()->get("xmap5");
        $ymap5 = $this->getConfig()->get("ymap5");
        $zmap5 = $this->getConfig()->get("zmap5");

        foreach($map1 as $respawnmap1){
            $respawnmap1->teleport(new Vector3($xmap1, $ymap1, $zmap1, $map1));
        }

        foreach($map2 as $respawnmap2){
            $respawnmap2->teleport(new Vector3($xmap2, $ymap2, $zmap2, $map2));
        }

        foreach($map3 as $respawnmap3){
            $respawnmap3->teleport(new Vector3($xmap3, $ymap3, $zmap3, $map3));
        }

        foreach($map4 as $respawnmap4){
            $respawnmap4->teleport(new Vector3($xmap4, $ymap4, $zmap4, $map4));
        }

        foreach($map5 as $respawnmap5){
            $respawnmap5->teleport(new Vector3($xmap5, $ymap5, $zmap5, $map5));
        }
    }

    public function onBlockBreak(BlockBreakEvent $event){
        $player = $event->getPlayer();

        $map1 = $this->getConfig()->get("map1");
        $map2 = $this->getConfig()->get("map2");
        $map3 = $this->getConfig()->get("map3");
        $map4 = $this->getConfig()->get("map4");
        $map5 = $this->getConfig()->get("map5");
        $lobby = $this->getConfig()->get("lobby");

        foreach($map1 as $p){
            $event->setCancelled(true);
        }

        foreach($map2 as $p2){
            $event->setCancelled(true);
        }

        foreach($map3 as $p3){
            $event->setCancelled(true);
        }

        foreach($map4 as $p3){
            $event->setCancelled(true);
        }

        foreach($map5 as $p5){
            $event->setCancelled(true);
        }

        foreach($lobby as $pl){
            $event->setCancelled(true);
        }
    }

    public function onBlockPlace(BlockPlaceEvent $event){
        $player = $event->getPlayer();

        $map1 = $this->getConfig()->get("map1");
        $map2 = $this->getConfig()->get("map2");
        $map3 = $this->getConfig()->get("map3");
        $map4 = $this->getConfig()->get("map4");
        $map5 = $this->getConfig()->get("map5");
        $lobby = $this->getConfig()->get("lobby");

        foreach($map1 as $p){
            $event->setCancelled(true);
        }

        foreach($map2 as $p2){
            $event->setCancelled(true);
        }

        foreach($map3 as $p3){
            $event->setCancelled(true);
        }

        foreach($map4 as $p3){
            $event->setCancelled(true);
        }

        foreach($map5 as $p5){
            $event->setCancelled(true);
        }

        foreach($lobby as $pl){
            $event->setCancelled(true);
        }
    }

    public function onDamage(EntityDamageEvent $event)
    {
        $player = $event->getEntity();

        $map1 = $this->getConfig()->get("map1");
        $map2 = $this->getConfig()->get("map2");
        $map3 = $this->getConfig()->get("map3");
        $map4 = $this->getConfig()->get("map4");
        $map5 = $this->getConfig()->get("map5");
        $lobby = $this->getConfig()->get("lobby");

        foreach ($map1 as $p) {
            $event->setCancelled(true);
        }

        foreach ($map2 as $p2) {
            $event->setCancelled(true);
        }

        foreach ($map3 as $p3) {
            $event->setCancelled(true);
        }

        foreach ($map4 as $p3) {
            $event->setCancelled(true);
        }

        foreach ($map5 as $p5) {
            $event->setCancelled(true);
        }

        foreach ($lobby as $pl) {
            $event->setCancelled(true);
        }
    }

    public function onItemDrop(PlayerDropItemEvent $event){
        $player = $event->getPlayer();

        $map1 = $this->getConfig()->get("map1");
        $map2 = $this->getConfig()->get("map2");
        $map3 = $this->getConfig()->get("map3");
        $map4 = $this->getConfig()->get("map4");
        $map5 = $this->getConfig()->get("map5");
        $lobby = $this->getConfig()->get("lobby");

        foreach ($map1 as $p) {
            $event->setCancelled(true);
        }

        foreach ($map2 as $p2) {
            $event->setCancelled(true);
        }

        foreach ($map3 as $p3) {
            $event->setCancelled(true);
        }

        foreach ($map4 as $p3) {
            $event->setCancelled(true);
        }

        foreach ($map5 as $p5) {
            $event->setCancelled(true);
        }

        foreach ($lobby as $pl) {
            $event->setCancelled(true);
        }
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();

        $map1 = $this->getConfig()->get("map1");
        $map2 = $this->getConfig()->get("map2");
        $map3 = $this->getConfig()->get("map3");
        $map4 = $this->getConfig()->get("map4");
        $map5 = $this->getConfig()->get("map5");
        $lobby = $this->getConfig()->get("lobby");

        foreach ($map1 as $p) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();

        }

        foreach ($map2 as $p2) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map3 as $p3) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map4 as $p3) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map5 as $p5) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($lobby as $pl) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();

        $map1 = $this->getConfig()->get("map1");
        $map2 = $this->getConfig()->get("map2");
        $map3 = $this->getConfig()->get("map3");
        $map4 = $this->getConfig()->get("map4");
        $map5 = $this->getConfig()->get("map5");
        $lobby = $this->getConfig()->get("lobby");

        foreach ($map1 as $p) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();

        }

        foreach ($map2 as $p2) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map3 as $p3) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map4 as $p3) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map5 as $p5) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($lobby as $pl) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }
    }

    public function onLogin(PlayerLoginEvent $event){
        $player = $event->getPlayer();

        $map1 = $this->getConfig()->get("map1");
        $map2 = $this->getConfig()->get("map2");
        $map3 = $this->getConfig()->get("map3");
        $map4 = $this->getConfig()->get("map4");
        $map5 = $this->getConfig()->get("map5");
        $lobby = $this->getConfig()->get("lobby");

        foreach ($map1 as $p) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();

        }

        foreach ($map2 as $p2) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map3 as $p3) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map4 as $p3) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($map5 as $p5) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }

        foreach ($lobby as $pl) {
            $p->setHealth(20);
            $p->setFood(20);
            $p->getInventory()->clearAll();
            $p->removeEffect();
        }
    }

}
