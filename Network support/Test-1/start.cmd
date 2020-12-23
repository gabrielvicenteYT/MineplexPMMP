@echo off
TITLE PocketMine-MP server software for Minecraft: Pocket Edition
cd /d %~dp0

if exist D:\PocketMine-MP\bin\php\php.exe (
	set PHPRC=""
	set PHP_BINARY=D:\PocketMine-MP\bin\php\php.exe
) else (
	set PHP_BINARY=php
)

if exist PocketMine-MP.phar (
	set POCKETMINE_FILE=PocketMine-MP.phar
) else (
	if exist D:\PocketMine-MP\src\pocketmine\PocketMine.php (
		set POCKETMINE_FILE=D:\PocketMine-MP\src\pocketmine\PocketMine.php
	) else (
		echo Couldn't find a valid PocketMine-MP installation
		pause
		exit 1
	)
)
if not exist players (
mkdir players
)
if not exist plugins (
mkdir plugins
)
if not exist plugin_data (
mkdir plugin_data
)
set PLAYERS = players\
set PLUGINS = plugins\
set PLUGINS_DATA= plugin_data\

if exist D:\PocketMine-MP\bin\mintty.exe (
	start "" D:\PocketMine-MP\bin\mintty.exe -o Columns=88 -o Rows=32 -o AllowBlinking=0 -o FontQuality=3 -o Font="Consolas" -o FontHeight=10 -o CursorType=0 -o CursorBlinks=1 -h error -t "test" -i bin/pocketmine.ico -w max %PHP_BINARY% %POCKETMINE_FILE% --enable-ansi %* -plugins %PLUGINS% -plugins_data %PLUGINS_DATA%
) else (
	REM pause on exitcode != 0 so the user can see what went wrong
	%PHP_BINARY% -c D:\PocketMine-MP\bin\php %POCKETMINE_FILE% %* || pause
)
