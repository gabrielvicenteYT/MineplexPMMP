-- #! mysql
-- #{ server
	-- #{ insert
	-- # :serverid string
    -- # :status string
    -- # :players int
    -- # :maxplayer int
		INSERT INTO servers(serverid, status, players, maxplayer) VALUES (:serverid, :status, :players, :maxplayer)
	-- #}
	-- #{ find
	-- # :serverid string
		SELECT * FROM servers WHERE serverid=:serverid;
	-- #}
	-- #{ update
		-- #{ status
		-- # :serverid string
    	-- # :status string
			UPDATE servers SET status = :status WHERE serverid=:serverid
		-- #}
		-- #{ players
		-- # :serverid string
    	-- # :players int
			UPDATE servers SET players = :players WHERE serverid=:serverid
		-- #}
		-- #{ maxplayer
		-- # :serverid string
    	-- # :maxplayer int
			UPDATE servers SET maxplayer = :maxplayer WHERE serverid=:serverid
		-- #}
	-- #}
-- #}