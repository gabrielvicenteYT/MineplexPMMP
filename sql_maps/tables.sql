-- #! mysql
-- #{ tables
    -- #{ servers
    CREATE TABLE servers(`server_id` VARCHAR(20) NOT NULL DEFAULT `undefined-1`, `status` INT NOT NULL, `players` INT NOT NULL, `max_players` INT NOT NULL, PRIMARY KEY(server_id));
    -- #}
    -- #{ players
    CREATE TABLE players(`xuid` BIGINT NOT NULL DEFAULT `-1`, `name` TEXT NOT NULL, `gems` INT NOT NULL, `coins` INT NOT NULL, `group` INT NOT NULL, PRIMARY KEY(xuid));
    -- #}
-- #}