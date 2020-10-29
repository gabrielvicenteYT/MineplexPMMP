-- #! mysql
-- #{ players
	-- #{ insert
	-- # :xuid int
    -- # :gems int
    -- # :coins int
    -- # :group int
		INSERT INTO players(`xuid`, `gems`, `coins`, `group`) VALUES (:xuid, :gems, :coins, :group)
	-- #}
	-- #{ find
	-- # :xuid int
		SELECT * FROM players WHERE `xuid`=:xuid;
	-- #}
	-- #{ update
		-- #{ gems
		-- # :xuid int
    	-- # :gems int
			UPDATE players SET `gems` = :gems WHERE `xuid`=:xuid
		-- #}
		-- #{ coins
		-- # :xuid int
    	-- # :coins int
			UPDATE players SET `coins` = :coins WHERE `xuid`=:xuid
		-- #}
		-- #{ group
		-- # :xuid int
    	-- # :group int
			UPDATE players SET `group` = :group WHERE `xuid`=:xuid
		-- #}
	-- #}
-- #}