-- #! mysql
-- #{ players
	-- #{ insert
	-- # :xuid int
    -- # :gems int
    -- # :coins int
    -- # :rank int
		INSERT INTO players(xuid, gems, coins, rank) VALUES (:xuid, :gems, :coins, :rank)
	-- #}
	-- #{ find
	-- # :xuid int
		SELECT * FROM players WHERE xuid=:xuid;
	-- #}
	-- #{ update
		-- #{ gems
		-- # :xuid int
    	-- # :gems int
			UPDATE players SET gems = :gems WHERE xuid=:xuid
		-- #}
		-- #{ coins
		-- # :xuid int
    	-- # :coins int
			UPDATE players SET coins = :coins WHERE xuid=:xuid
		-- #}
		-- #{ rank
		-- # :xuid int
    	-- # :rank int
			UPDATE players SET rank = :rank WHERE xuid=:xuid
		-- #}
	-- #}
-- #}