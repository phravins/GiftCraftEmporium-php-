@echo off
echo Initializing Database...
php setup.php
if %errorlevel% neq 0 (
    echo Failed to run setup.php. Please make sure PHP is installed and in your PATH.
    pause
    exit /b
)

echo.
echo Starting GiftShop Server...
echo Access at http://127.0.0.1:8000
php -S 127.0.0.1:8000
pause
