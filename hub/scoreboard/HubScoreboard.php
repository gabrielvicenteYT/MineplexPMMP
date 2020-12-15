<?php

declare(strict_types=1);

namespace DinoVNOwO\Hub\scoreboard;

use DinoVNOwO\Base\Initial;
use DinoVNOwO\Base\scoreboard\Scoreboard;
use DinoVNOwO\Base\session\Session;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
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
        $server->customName = TextFormat::colorize("&l&8>&6 Server");
        $server->score = 1;
        $server->scoreboardId = 1;
        $this->defaultentries[] = $server;

        //Server
        $server = clone $default;
        $server->customName = Initial::getManager(Initial::CONFIG)->getServerId();
        $server->score = 2;
        $server->scoreboardId = 2;
        $this->defaultentries[] = $server;

        $gaps1 = clone $default;
        $gaps1->customName = " ";
        $gaps1->score = 3;
        $gaps1->scoreboardId = 3;
        $this->defaultentries[] = $gaps1;

        $rank = clone $default;
        $rank->customName = TextFormat::colorize("&l&8>&6 Rank");
        $rank->score = 4;
        $rank->scoreboardId = 4;
        $this->defaultentries[] = $rank;

        $gaps4 = clone $default;
        $gaps4->customName = "  ";
        $gaps4->score = 6;
        $gaps4->scoreboardId = 6;
        $this->defaultentries[] = $gaps4;

        $website = clone $default;
        $website->customName = TextFormat::colorize("&l&8>&6 Website");
        $website->score = 7;
        $website->scoreboardId = 7;
        $this->defaultentries[] = $website;

        $website = clone $default;
        $website->customName = "www.example.com";
        $website->score = 8;
        $website->scoreboardId = 8;
        $this->defaultentries[] = $website;

        $end = clone $default;
        $end->customName = "----------------";
        $end->score = 9;
        $end->scoreboardId = 9;
        $this->defaultentries[] = $end;
    }

    public function getId() : string{
        return "hub";
    }

    public function updateScore(Session $session, array $entries = []): void
    {
        $entries = $this->defaultentries;
        $rank = new ScorePacketEntry();
        $rank->objectiveName = "objective";
        $rank->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
        $rank->customName = $session->getGroup()->getName();
        $rank->score = 5;
        $rank->scoreboardId = 5;
        $entries[] = $rank;
        parent::updateScore($session, $entries);
    }
}