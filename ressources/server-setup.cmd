title Setup of the server configuration
cls
echo Setup of the server configuration

echo Do you want to continue ? 
pause

echo Create .const.php with the .const.php.example
cd ..
copy .const.php.example app
cd app
rename .const.php.example .const.php

echo The script is finished !
pause