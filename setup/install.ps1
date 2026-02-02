# PHP Labs - Full Windows Setup Script
# Повне встановлення всього необхідного ПЗ

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  PHP Labs - Повне встановлення" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Цей скрипт встановить все необхідне ПЗ:" -ForegroundColor White
Write-Host "  - PHP 8.x" -ForegroundColor White
Write-Host "  - Git" -ForegroundColor White
Write-Host "  - Composer" -ForegroundColor White
Write-Host "  - MySQL" -ForegroundColor White
Write-Host ""
Write-Host "Якщо вам потрібна тільки базова установка (ЛР 1-5):" -ForegroundColor Yellow
Write-Host "  .\install-basic.ps1" -ForegroundColor White
Write-Host ""

$answer = Read-Host "Продовжити повну установку? (y/n)"
if ($answer -ne "y" -and $answer -ne "Y") {
    Write-Host "Скасовано. Для базової установки: .\install-basic.ps1" -ForegroundColor Yellow
    exit 0
}
Write-Host ""

# Function to check if a command exists
function Test-Command {
    param($Command)
    return [bool](Get-Command -Name $Command -ErrorAction SilentlyContinue)
}

# Install Scoop
function Install-Scoop {
    Write-Host ">>> Перевірка Scoop..." -ForegroundColor Yellow

    if (Test-Command "scoop") {
        Write-Host "[OK] Scoop вже встановлено" -ForegroundColor Green
    }
    else {
        Write-Host "  Встановлення Scoop..." -ForegroundColor Yellow
        Set-ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
        Invoke-Expression (New-Object System.Net.WebClient).DownloadString('https://get.scoop.sh')
        $env:Path = [System.Environment]::GetEnvironmentVariable("Path", "Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path", "User")
        Write-Host "[OK] Scoop встановлено!" -ForegroundColor Green
    }
    Write-Host ""
}

# Install PHP
function Install-PHP {
    Write-Host ">>> Перевірка PHP..." -ForegroundColor Yellow

    if (Test-Command "php") {
        Write-Host "[OK] PHP вже встановлено: $(php -v | Select-Object -First 1)" -ForegroundColor Green
    }
    else {
        Write-Host "  Встановлення PHP..." -ForegroundColor Yellow
        scoop install php
        Write-Host "[OK] PHP встановлено!" -ForegroundColor Green
    }
    Write-Host ""
}

# Install Git
function Install-Git {
    Write-Host ">>> Перевірка Git..." -ForegroundColor Yellow

    if (Test-Command "git") {
        Write-Host "[OK] Git вже встановлено: $(git --version)" -ForegroundColor Green
    }
    else {
        Write-Host "  Встановлення Git..." -ForegroundColor Yellow
        scoop install git
        Write-Host "[OK] Git встановлено!" -ForegroundColor Green
    }
    Write-Host ""
}

# Install Composer
function Install-Composer {
    Write-Host ">>> Перевірка Composer..." -ForegroundColor Yellow

    if (Test-Command "composer") {
        Write-Host "[OK] Composer вже встановлено: $(composer --version)" -ForegroundColor Green
    }
    else {
        Write-Host "  Встановлення Composer..." -ForegroundColor Yellow
        scoop install composer
        Write-Host "[OK] Composer встановлено!" -ForegroundColor Green
    }
    Write-Host ""
}

# Install MySQL
function Install-MySQL {
    Write-Host ">>> Перевірка MySQL..." -ForegroundColor Yellow

    if (Test-Command "mysql") {
        Write-Host "[OK] MySQL вже встановлено: $(mysql --version)" -ForegroundColor Green
    }
    else {
        Write-Host "  Встановлення MySQL..." -ForegroundColor Yellow
        scoop install mysql
        Write-Host "[OK] MySQL встановлено!" -ForegroundColor Green
    }
    Write-Host ""
}

# Main function
Write-Host "Починаю повне встановлення..." -ForegroundColor Cyan
Write-Host ""

Install-Scoop
Install-PHP
Install-Git
Install-Composer
Install-MySQL

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  Повне встановлення завершено!" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "Встановлено:" -ForegroundColor Yellow
try { Write-Host "  PHP:      $(php -v | Select-Object -First 1)" -ForegroundColor White } catch { Write-Host "  PHP:      не встановлено" -ForegroundColor Red }
try { Write-Host "  Git:      $(git --version)" -ForegroundColor White } catch { Write-Host "  Git:      не встановлено" -ForegroundColor Red }
try { Write-Host "  Composer: $(composer --version 2>&1)" -ForegroundColor White } catch { Write-Host "  Composer: не встановлено" -ForegroundColor Red }
try { Write-Host "  MySQL:    $(mysql --version 2>&1)" -ForegroundColor White } catch { Write-Host "  MySQL:    не встановлено" -ForegroundColor Red }

Write-Host ""
Write-Host "Тепер ви можете:" -ForegroundColor Yellow
Write-Host "  php filename.php        # запустити PHP файл" -ForegroundColor White
Write-Host "  php -S localhost:8000   # локальний сервер" -ForegroundColor White
Write-Host ""
Write-Host "ВАЖЛИВО: Перезапустіть термінал для оновлення PATH!" -ForegroundColor Magenta
Write-Host ""
