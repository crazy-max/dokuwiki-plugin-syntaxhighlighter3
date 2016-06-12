@ECHO OFF
CHCP 1252>NUL
SETLOCAL EnableDelayedExpansion

set binpath=%~dp0bin
set distpath=%~dp0dist
set filename=syntaxhighlighter3
set filepath=%distpath%\%filename%.tar.gz
set buildPath=%binpath%\%filename%

:: create bin path and dist path
rd /s /q "%binpath%" 2>NUL
mkdir "%binpath%"
if not exist "%distpath%" mkdir "%distpath%"

:: copy plugin folder
xcopy /e /i /y "%~dp0syntaxhighlighter3" "%buildPath%"

:: copy others files
copy /y "%~dp0CHANGELOG.md" "%buildPath%"
copy /y "%~dp0LICENSE" "%buildPath%"
copy /y "%~dp0README.md" "%buildPath%"

:: create archive
del /f /q "%filepath%" 2>NUL
"%~dp0tools\7z.exe" a -ttar -so "%distpath%\%filename%" "%buildPath%" | "%~dp0\tools\7z.exe" a -si "%filepath%"

PAUSE
ENDLOCAL
