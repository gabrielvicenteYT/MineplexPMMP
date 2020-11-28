<?php

declare(strict_types=1);

namespace DinoVNOwO\Base\hub\scoreboard;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\scoreboard\Scoreboard;
use DinoVNOwO\Base\session\Session;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class HubScoreboard extends Scoreboard{

    private $defaultentries = [];

    public function __construct()
    {
        parent::__construct();
        $this->setScoreboardDisplayName(TextFormat::colorize("&l&6Entro&fMC"));
        $default = new ScorePacketEntry();
        $default->objectiveName = "objective";
        $default->type = ScorePacketEntry::TYPE_FAKE_PLAYER;

        $server = clone $default;
        $server->customName = TextFormat::colorize("&l&bServer");
        $server->score = 1;
        $server->scoreboardId = 1;
        $this->defaultentries[] = $server;

        $gaps1 = clone $default;
        $gaps1->customName = " ";
        $gaps1->score = 3;
        $gaps1->scoreboardId = 3;
        $this->defaultentries[] = $gaps1;

        $gems = clone $default;
        $gems->customName = TextFormat::colorize("&a&lGems");
        $gems->score = 4;
        $gems->scoreboardId = 4;
        $this->defaultentries[] = $gems;

        $gaps2 = clone $default;
        $gaps2->customName = TextFormat::colorize("  ");
        $gaps2->score = 6;
        $gaps2->scoreboardId = 6;
        $this->defaultentries[] = $gaps2;

        $coins = clone $default;
        $coins->customName = TextFormat::colorize("&e&lCoins");
        $coins->score = 7;
        $coins->scoreboardId = 7;
        $this->defaultentries[] = $coins;

        $gaps3 = clone $default;
        $gaps3->customName = "   ";
        $gaps3->score = 9;
        $gaps3->scoreboardId = 9;
        $this->defaultentries[] = $gaps3;

        $ranks = clone $default;
        $ranks->customName = TextFormat::colorize("&6&lRanks");
        $ranks->score = 10;
        $ranks->scoreboardId = 10;
        $this->defaultentries[] = $ranks;

        $gaps4 = clone $default;
        $gaps4->customName = "    ";
        $gaps4->score = 12;
        $gaps4->scoreboardId = 12;
        $this->defaultentries[] = $gaps4;

        $website = clone $default;
        $website->customName = TextFormat::colorize("&c&lWebsite");
        $website->score = 13;
        $website->scoreboardId = 13;
        $this->defaultentries[] = $website;

        $website = clone $default;
        $website->customName = "www.mineplex.com";
        $website->score = 14;
        $website->scoreboardId = 14;
        $this->defaultentries[] = $website;

        $end = clone $default;
        $end->customName = "----------------";
        $end->score = 15;
        $end->scoreboardId = 15;
        $this->defaultentries[] = $end;
    }

    public function getId() : string{
        return "hub";
    }

    public function updateScore(Session $session, array $entries = []): void
    {
        $entries = $this->defaultentries;
        $value = new ScorePacketEntry();
        $value->objectiveName = "objective";
        $value->type = ScorePacketEntry::TYPE_FAKE_PLAYER;

        //Server
        $server = clone $value;
        $server->customName = Initial::getConfigManager()->getServerId();
        $server->score = 2;
        $server->scoreboardId = 2;
        $entries[] = $server;

        //Gems
        $gems = clone $value;
        $gems->customName = (string) $session->getGems();
        $gems->score = 5;
        $gems->scoreboardId = 5;
        $entries[] = $gems;

        //Coins
        $coins = clone $value;
        $coins->customName = (string) $session->getCoins();
        $coins->score = 8;
        $coins->scoreboardId = 8;
        $entries[] = $coins;
        //Ranks
        $ranks = clone $value;
        $ranks->customName = $session->getGroup()->getName();
        $ranks->score = 11;
        $ranks->scoreboardId = 11;
        $entries[] = $ranks;

        parent::updateScore($session, $entries);
    }
}