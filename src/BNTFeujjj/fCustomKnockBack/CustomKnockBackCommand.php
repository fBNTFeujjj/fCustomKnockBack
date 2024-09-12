<?php

namespace BNTFeujjj\fCustomKnockBack;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use jojoe77777\FormAPI\CustomForm;
use BNTFeujjj\fCustomKnockBack\Main;

class CustomKnockBackCommand extends Command {

    public function __construct() {
        parent::__construct("customknockback", "§6Permet de changer les paramètres des KB.", "/customknockback", []);
        $this->setPermission(DefaultPermissions::ROOT_OPERATOR);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cVous devez être un joueur pour utiliser cette commande.");
            return;
        }

        $this->openConfigForm($sender);
    }

    private function openConfigForm(Player $player) {
        $form = new CustomForm(function(Player $player, ?array $data) {
            if($data === null) {
                return;
            }

            $knockback = (float) $data[0];
            $attackCooldown = (float) $data[1];

            $config = Main::getInstance()->getConfig();
            $config->set("knockback", $knockback);
            $config->set("attackcooldown", $attackCooldown);
            $config->save();

            $player->sendMessage("§aLa configuration de fCustomKnockBack a été update avec succès !");
        });

        $config = Main::getInstance()->getConfig();
        $form->setTitle("§3[§6Custom Knockback Configuration§3]");
        $form->addInput("Knockback", "Veuillez entrer la nouvelle valeur des KB ici", (string) $config->get("knockback", "0.4"));
        $form->addInput("Attack Cooldown", "Veuillez entrer la nouvelle valeur de l'attack cooldown ici", (string) $config->get("attackcooldown", "0.5"));
        $player->sendForm($form);
    }
}
