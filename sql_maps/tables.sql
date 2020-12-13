-- #! mysql
-- #{ tables
    -- #{ servers
    CREATE TABLE servers(`id` VARCHAR(20) NOT NULL, `ip` INT NOT NULL, `port` INT NOT NULL, PRIMARY KEY(id));
    -- #}
    -- #{ players
    CREATE TABLE players(`xuid` BIGINT NOT NULL DEFAULT `-1`, `name` TEXT NOT NULL, `gems` INT NOT NULL, `coins` INT NOT NULL, `group` INT NOT NULL, PRIMARY KEY(xuid));
    -- #}
-- #}