-- #! mysql
-- #{ servers
	-- #{ insert
	-- # :id string
    -- # :status string
    -- # :players int
    -- # :maxplayers int
		INSERT INTO servers(id, status, players, maxplayers) VALUES (:id, :status, :players, :maxplayers)
	-- #}
	-- #{ find
	-- # :id string
		SELECT * FROM servers WHERE id=:id;
	-- #}
	-- #{ update
		-- #{ status
		-- # :id string
    	-- # :status string
			UPDATE servers SET status = :status WHERE id=:id
		-- #}
		-- #{ players
		-- # :id string
    	-- # :players int
			UPDATE servers SET players = :players WHERE id=:id
		-- #}
		-- #{ maxplayers
		-- # :id string
    	-- # :maxplayers int
			UPDATE servers SET maxplayers = :maxplayers WHERE id=:id
		-- #}
	-- #}
-- #}