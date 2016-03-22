<?php

  namespace TimeBan;

  use pocketmine\plugin\PluginBase;
  use pocketmine\event\Listener;
  use pocketmine\event\player\PlayerPreLoginEvent;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\utils\Config;
  use pocketmine\Player;

  class Main extends PluginBase implements Listener
  {

    private $bans = array();

    public function dataPath()
    {

      return $this->getDataFolder();

    }

    public function server()
    {

      return $this->getServer();

    }

    public function onEnable()
    {

      $this->server()->getPluginManager()->registerEvents($this, $this);

      @mkdir($this->dataPath());

      $this->cfg = new Config($this->dataPath() . "banned-users.txt", Config::ENUM, array("banned_users" => array()));

    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args)
    {

      if(strtolower($cmd->getName()) === "timeban")
      {

        if(!(isset($args[0])))
        {

          $sender->sendMessage(TF::RED . "Error: not enough args. Usage: /timeban <player> <reason> <time(In Seconds)>");

          return true;

        }
        else
        {

          $name = $args[0];

          $player = $this->server()->getPlayer($name);

          if($player === null)
          {

            $sender->sendMessage(TF::RED . "Player " . $name . " is not online.");

            return true;

          }
          else
          {

            $player_name = $player->getName();

            $player_client_id = $player->getClientId();

            $banned_users = $this->cfg->get("banned_users");

            if(isset($this->bans[$player_name]))
            {

              $sender->sendMessage(TF::RED . $player_name . " is already banned.");

              return true;

            }

          }

        }

      }

    }

    public function onPreLogin(PlayerPreLoginEvent $event)
    {

    }

  }

?>
