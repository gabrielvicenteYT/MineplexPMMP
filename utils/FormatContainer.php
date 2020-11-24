<?php

namespace DinoVNOwO\Base\utils;

use pocketmine\utils\TextFormat;

class FormatContainer{

    public const PERMISSION_NOT_FOUND = "&l&6Permissions&9 >&r&c You are not allowed to execute this command.";

    public const ARGUMENT_MISSING = "&l&6Arguments&9 >&r&c You are missing an argument.";
    public const ARGUMENT_INVALID = "&l&6Arguments&9 >&r&c Your arguments isn't quite right.";
    public const ARGUMENT_TOO_MANY = "&l&6Arguments&9 >&r&c You inserted too many arguments.";
    public const PLAYER_OFFLINE = "&l&6Arguments&9 >&r&c The player you inserted is currently not online.";

    public const DATA_UPDATE_SUCCESS = "&l&6Datastorage&9 >&r&a Updated {name}'s {type} to {current}.";

    public const GROUP_UPDATE_SUCCESS = "&l&6Datastorage&9 >&r&a Updated {name}'s {type} to {current}.";

    public const PLAYER_QUIT = "&l&6Server&9 >&r&a {name} joined the server.";

    public const PLAYER_JOIN = "&l&6Server&9 >&r&a {name} quit the servers.";

}