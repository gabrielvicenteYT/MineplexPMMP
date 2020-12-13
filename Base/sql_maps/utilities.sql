-- #! mysql
-- #{ utilities
	-- #{ search_table
	-- # :table_name string
	SELECT table_name FROM information_schema.tables WHERE table_schema = 'mineplex' AND table_name = :table_name;
	-- #}
-- #}