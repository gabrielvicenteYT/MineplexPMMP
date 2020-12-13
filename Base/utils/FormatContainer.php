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

    public const PLAYER_JOIN = "&l&6Server&9 >&r&a {name} joined the server.";

    public const PLAYER_QUIT = "&l&6Server&9 >&r&a {name} quit the servers.";

    public const ACTIVE_PARTICLE_COSMETIC = "&l&dCosmetics&a >&r&a Activated&e {cosmetic_name}";

    public const DISABLE_PARTICLE_COSMETIC = "&l&dCosmetics&a >&r&c Disabled&e {cosmetic_name}";

    public const SERVER_SELECTOR_FORM_NAME = "&l&aServers";
    public const SERVER_SELECTOR_FORM_LINE = "Select one of the servers";
    public const SKYBLOCK_SERVER_BUTTON_NAME = "&l&6Skyblock &8<&a{online}&8/&e{max}&8>";

    public const PARTICLE_FORM_NAME = "&l&aServers";
    public const PARTICLE_FORM_LINE = "Select one of the category";

    public static function format(string $message, array $keys = [], array $values = []) : string{
        return TextFormat::colorize(str_replace($keys, $values, $message));
    }

}