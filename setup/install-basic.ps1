# PHP Labs - Basic Windows Setup Script
# Базове встановлення: PHP, Git

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  PHP Labs - Базове встановлення" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
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

        # Update PATH
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

# Main function
Write-Host "Починаю базове встановлення..." -ForegroundColor Cyan
Write-Host ""

Install-Scoop
Install-PHP
Install-Git

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  Базове встановлення завершено!" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "Встановлено:" -ForegroundColor Yellow
try { Write-Host "  PHP: $(php -v | Select-Object -First 1)" -ForegroundColor White } catch { Write-Host "  PHP: не встановлено" -ForegroundColor Red }
try { Write-Host "  Git: $(git --version)" -ForegroundColor White } catch { Write-Host "  Git: не встановлено" -ForegroundColor Red }

Write-Host ""
Write-Host "Тепер ви можете:" -ForegroundColor Yellow
Write-Host "  php filename.php        # запустити PHP файл" -ForegroundColor White
Write-Host "  php -S localhost:8000   # локальний сервер" -ForegroundColor White
Write-Host ""
Write-Host "Для лабораторних 6-7 (Laravel) запустіть:" -ForegroundColor Yellow
Write-Host "  .\install-laravel.ps1" -ForegroundColor White
Write-Host ""
Write-Host "ВАЖЛИВО: Перезапустіть термінал для оновлення PATH!" -ForegroundColor Magenta
Write-Host ""
