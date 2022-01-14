@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../jolicode/jolinotif/jolinotif
php "%BIN_TARGET%" %*
