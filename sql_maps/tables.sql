-- #! mysql
-- #{ tables
    -- #{ servers
    CREATE TABLE servers(id VARCHAR(20) NOT NULL DEFAULT "undefined-1", status INT NOT NULL, players INT NOT NULL, maxplayers INT NOT NULL, PRIMARY KEY(id));
    -- #}
    -- #{ players
    CREATE TABLE players(xuid BIGINT NOT NULL DEFAULT "-1", gems INT NOT NULL, coins INT NOT NULL, rank INT NOT NULL, PRIMARY KEY(xuid));
    -- #}
-- #}