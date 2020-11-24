-- #! mysql
-- #{ players
	-- #{ insert
	-- # :xuid int
	-- # :name string
    -- # :gems int
    -- # :coins int
    -- # :group int
		INSERT INTO players(`xuid`, `name`, `gems`, `coins`, `group`) VALUES (:xuid, :name, :gems, :coins, :group)
	-- #}
	-- #{ find
		-- #{ xuid
			-- # :xuid int
			SELECT * FROM players WHERE `xuid`=:xuid;
		-- #}
		-- #{ name
			-- # :name string
			SELECT * FROM players WHERE `name`=:name;
		-- #}
	-- #}
	-- #{ update
		-- #{ xuid
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
		-- #{ name
			-- #{ gems
			-- # :name string
    		-- # :gems int
				UPDATE players SET `gems` = :gems WHERE `name`=:name
			-- #}
			-- #{ coins
			-- # :name string
    		-- # :coins int
				UPDATE players SET `coins` = :coins WHERE `name`=:name
			-- #}
			-- #{ group
			-- # :name string
    		-- # :group int
				UPDATE players SET `group` = :group WHERE `name`=:name
			-- #}
		-- #}
	-- #}
-- #}