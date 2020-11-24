-- #! mysql
-- #{ servers
	-- #{ insert
	-- # :server_id string
    -- # :status string
    -- # :players int
    -- # :max_players int
		INSERT INTO servers(server_id, status, players, max_players) VALUES (:server_id, :status, :players, :max_players)
	-- #}
	-- #{ find
	-- # :server_id string
		SELECT * FROM servers WHERE server_id=:server_id;
	-- #}
	-- #{ update
		-- #{ status
		-- # :server_id string
    	-- # :status string
			UPDATE servers SET status = :status WHERE server_id=:server_id
		-- #}
		-- #{ players
		-- # :server_id string
    	-- # :players int
			UPDATE servers SET players = :players WHERE server_id=:server_id
		-- #}
		-- #{ max_players
		-- # :server_id string
    	-- # :max_players int
			UPDATE servers SET max_players = :max_players WHERE server_id=:server_id
		-- #}
		-- #{ server_id
		-- # :server_id_old string
		-- # :server_id_new string
			UPDATE servers SET server_id = :server_id_new WHERE server_id=:server_id_old
		-- #}
	-- #}
-- #}