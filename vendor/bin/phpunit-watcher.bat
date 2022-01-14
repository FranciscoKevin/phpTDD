@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../spatie/phpunit-watcher/phpunit-watcher
php "%BIN_TARGET%" %*
