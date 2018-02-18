<?php
/**
 * Created by PhpStorm.
 * User: pacma
 * Date: 1/26/2018
 * Time: 5:48 PM
 */

namespace FactionsUI;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\{command\ConsoleCommandSender, Server, Player, utils\TextFormat};
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("FactionsUI made By QuiverlyRivalry\nThis is a private plugin, want more plugins?\n Contact here QuiverlyRivalry#4535\n on Discord!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        $player = $sender->getPlayer();
        switch($command->getName()){
            case "fui":
                $this->menuForm($player);
        }
        return true;
    }

    public function menuForm($player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //Create a Faction
                            $this->createFactionForm($sender);
                            break;
                        case 1:
                            //Leader Commands
                            $this->leaderCommandForm($sender);
                            break;
                        case 2:
                            //Officer Commands
                            $this->officerCommandForm($sender);
                            break;
                        case 3:
                            $this->generalCommandForm($sender);
                            break;
                        case 4:
                            //Exit
                            break;
                    }
                }
            });
            $form->setTitle("FactionUI");
            $form->setContent("Choose, an action!");
            $form->addButton(TextFormat::GREEN . "Create a Faction?\nIf your not in one!");
            $form->addButton("Faction Leader Commands");
            $form->addButton("Faction Officer Commands");
            $form->addButton("General Commands");
            $form->addButton(TextFormat::RED . "Exit");
            $form->sendToPlayer($player);
        }
    }

    public function createFactionForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->factionName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f create " . $this->factionName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Faction Creation");
        $form->addInput("Faction Name");
        $form->sendToPlayer($player);
    }

    public function leaderCommandForm($player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //f claim
                            $this->getServer()->getCommandMap()->dispatch($sender, "f claim");
                            break;
                        case 1:
                            //f demote
                            //
                            $this->demoteForm($sender);
                            break;
                        case 2:
                            //f kick
                            //
                            $this->kickForm($sender);
                            break;
                        case 3:
                            //f leader
                            //
                            $this->leaderForm($sender);
                            break;
                        case 4:
                            //f sethome
                            $this->getServer()->getCommandMap()->dispatch($sender, "f sethome");
                            break;
                        case 5:
                            //f unclaim
                            $this->getServer()->getCommandMap()->dispatch($sender, "f unclaim");
                            break;
                        case 6:
                            //f unsethome
                            $this->getServer()->getCommandMap()->dispatch($sender, "f unsethome");
                            break;
                        case 7:
                            //f desc
                            $this->getServer()->getCommandMap()->dispatch($sender, "f desc");
                            break;
                        case 8:
                            //f promote
                            //
                            $this->promoteForm($sender);
                            break;
                        case 9:
                            //f allywith <faction>
                            //
                            $this->allyForm($sender);
                            break;
                        case 10:
                            //f allyok
                            $this->getServer()->getCommandMap()->dispatch($sender, "f allyok");
                            break;
                        case 11:
                            //f allyno
                            $this->getServer()->getCommandMap()->dispatch($sender, "f allyno");
                            break;
                        case 12:
                            //f breakalliancewith <faction>
                            //
                            $this->breakAllianceForm($sender);
                            break;
                        case 13:
                            //f delete
                            $this->getServer()->getCommandMap()->dispatch($sender, "f del");
                            break;
                        case 14:
                            //Back
                            $this->menuForm($sender);
                            break;
                    }
                }
            });
            $form->setTitle("Leader Menu");
            $form->setContent("Hello, Leader! Controll your factions settings, and much more!\nI hope you dont delete it though...");
            $form->addButton("Claim a Faction Plot!");
            $form->addButton("Demote an Officer?");
            $form->addButton("Kick a member/officer");
            $form->addButton("Give someone leader!");
            $form->addButton("Set a Faction Home");
            $form->addButton("Unclaim a Faction Plot");
            $form->addButton("Unset your Factions Home");
            $form->addButton("Set your description.");
            $form->addButton("Promote an Officer");
            $form->addButton("Ally with a Faction!");
            $form->addButton("Accept an Ally Request");
            $form->addButton("Decline an Ally Request");
            $form->addButton("Break Alliance with a Faction");
            $form->addButton(TextFormat::RED . "Delete your\nFaction..?");
            $form->addButton("Back");
            $form->sendToPlayer($player);
        }
    }

    public function demoteForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f demote " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Demote an Officer");
        $form->addInput("Player Name");
        $form->sendToPlayer($player);
    }

    public function kickForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f kick " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Kick a Player");
        $form->addInput("Player Name to Kick");
        $form->sendToPlayer($player);
    }

    public function leaderForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->leaderName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f leader " . $this->leaderName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Transfer Ownership");
        $form->addInput("New Owner name");
        $form->sendToPlayer($player);
    }

    public function promoteForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->luckyPerson = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f promote " . $this->luckyPerson);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Promote an Member");
        $form->addInput("Members Name");
        $form->sendToPlayer($player);
    }

    public function allyForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->factionName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f allywith " . $this->factionName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Ally with a Faction");
        $form->addInput("Factions Name");
        $form->sendToPlayer($player);
    }

    public function breakAllianceForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->factionName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f breakalliancewith " . $this->factionName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Break Alliances");
        $form->addInput("Faction Name");
        $form->sendToPlayer($player);
    }

    public function inviteForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f invite " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Invite a Player");
        $form->addInput("Players Name");
        $form->sendToPlayer($player);
    }

    public function officerCommandForm($player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //Invite Someone
                            $this->inviteForm($sender);
                            break;
                        case 1:
                            $this->menuForm($sender);
                            break;
                    }
                }
            });
            $form->setTitle("Officer Menu");
            $form->setContent("Welcome, officers control your members here!\nNot many commands though...");
            $form->addButton("Invite a player!");
            $form->addButton(TextFormat::RED . "Exit");
            $form->sendToPlayer($player);
        }
    }

    public function generalCommandForm($player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //Info about a faction
                            //
                            $this->factionInfoForm($sender);
                            break;
                        case 1:
                            //f ourmembers
                            $this->getServer()->getCommandMap()->dispatch($sender, "f ourmembers");
                            break;
                        case 2:
                            //f ourofficerss
                            $this->getServer()->getCommandMap()->dispatch($sender, "f ourofficers");
                            break;
                        case 3:
                            //f ourleader
                            $this->getServer()->getCommandMap()->dispatch($sender, "f ourleader");
                            break;
                        case 4:
                            //f allies
                            $this->getServer()->getCommandMap()->dispatch($sender, "f allies");
                            break;
                        case 5:
                            //f membersof <faction>
                            //
                            $this->membersOf($sender);
                            break;
                        case 6:
                            //f officersof <faction>
                            //
                            $this->officersOf($sender);
                            break;
                        case 7:
                            //f leaderof <faction>
                            //
                            $this->leaderOf($sender);
                            break;
                        case 8:
                            //f topfactions
                            $this->getServer()->getCommandMap()->dispatch($sender, "f topfactions");
                            break;
                        case 9:
                            //f chat
                            $this->getServer()->getCommandMap()->dispatch($sender, "f chat");
                            break;
                        case 10:
                            //Exit
                            $this->menuForm($sender);
                    }
                }
            });
            $form->setTitle("General Commands");
            $form->setContent("Choose, an action! Faction Members!");
            $form->addButton("See info about a Faction");
            $form->addButton("See your Faction Members");
            $form->addButton("See your Factions Officers");
            $form->addButton("See your Factions Leader");
            $form->addButton("See your Factions Allies");
            $form->addButton("See members of anoother Faction!");
            $form->addButton("See Officers of another Faction!");
            $form->addButton("See Leaders of another Faction!");
            $form->addButton("See the Faction Leaderboard");
            $form->addButton("Activate your Faction Chat");
            $form->addButton(TextFormat::RED . "Exit");
            $form->sendToPlayer($player);
        }
    }

    public function factionInfoForm($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f info " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Info about a Faction");
        $form->addInput("Faction Name");
        $form->sendToPlayer($player);
    }

    public function membersOf($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f membersof " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Members of a Faction");
        $form->addInput("Faction Name");
        $form->sendToPlayer($player);
    }

    public function officersOf($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f officersof " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Officers of a Faction");
        $form->addInput("Faction Name");
        $form->sendToPlayer($player);
    }

    public function leaderOf($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "f leaderof " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Leader of a Faction");
        $form->addInput("Faction Name");
        $form->sendToPlayer($player);
    }


}
