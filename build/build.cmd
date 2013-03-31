@echo off

set NAME=jublog
set F=D:\Documentos\creaciones\com_%NAME%
set W=D:\www\25
set ZIP=C:\Users\Joni\Desktop\com_%NAME%.zip

set BUILD=%F%/build/com_%NAME%
set SITE=%F%/components/com_%NAME%
set ADMIN=%F%/administrator/components/com_%NAME%
set SITE_LANG=%F%/language
set ADMIN_LANG=%F%/administrator/language

rd "%BUILD%" /Q /S

mkdir "%BUILD%"
mkdir "%BUILD%/admin"
mkdir "%BUILD%/admin_lang"
mkdir "%BUILD%/site"
mkdir "%BUILD%/site_lang"

cd "%SITE_LANG%/es-ES/"
copy "es-ES.com_%NAME%.ini" "%BUILD%/site_lang/es-ES.com_%NAME%.ini"

cd "%SITE_LANG%/en-GB/"
copy "en-GB.com_%NAME%.ini" "%BUILD%/site_lang/en-GB.com_%NAME%.ini"

cd "%ADMIN_LANG%/es-ES/"
copy "es-ES.com_%NAME%.ini" "%BUILD%/admin_lang/es-ES.com_%NAME%.ini"
copy "es-ES.com_%NAME%.sys.ini" "%BUILD%/admin_lang/es-ES.com_%NAME%.sys.ini"

cd "%ADMIN_LANG%/en-GB/"
copy "en-GB.com_%NAME%.ini" "%BUILD%/admin_lang/en-GB.com_%NAME%.ini"
copy "en-GB.com_%NAME%.sys.ini" "%BUILD%/admin_lang/en-GB.com_%NAME%.sys.ini"

xcopy "%SITE%" "%BUILD%/site" /E /I
xcopy "%ADMIN%" "%BUILD%/admin" /E /I

cd "%BUILD%/admin/"
move "%NAME%.xml" "%BUILD%/%NAME%.xml"

cd "%F%/build"
copy "changelog.txt" "%BUILD%/changelog.txt"

"C:\Program Files\WinRAR\WinRAR.exe" a -ep1 -r -afzip -m5 "%ZIP%" "%BUILD%\*"

rd "%BUILD%" /Q /S

::WORK
xcopy "%F%/administrator" "%W%/administrator" /E /I /Y
xcopy "%F%/components" "%W%/components" /E /I /Y
xcopy "%F%/language" "%W%/language" /E /I /Y