# PHP Labs - Laravel Windows Setup Script
# Встановлення для Laravel: Composer, MySQL

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  PHP Labs - Встановлення Laravel" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""

# Function to check if a command exists
function Test-Command {
    param($Command)
    return [bool](Get-Command -Name $Command -ErrorAction SilentlyContinue)
}

# Check PHP prerequisite
function Check-PHP {
    Write-Host ">>> Перевірка PHP (обов'язкова залежність)..." -ForegroundColor Yellow

    if (Test-Command "php") {
        Write-Host "[OK] PHP встановлено: $(php -v | Select-Object -First 1)" -ForegroundColor Green
        Write-Host ""
        return $true
    }
    else {
        Write-Host "[X] PHP не встановлено!" -ForegroundColor Red
        Write-Host "  Спочатку запустіть: .\install-basic.ps1" -ForegroundColor Yellow
        Write-Host ""
        return $false
    }
}

# Check Scoop
function Check-Scoop {
    if (-not (Test-Command "scoop")) {
        Write-Host ">>> Встановлення Scoop..." -ForegroundColor Yellow
        Set-ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
        Invoke-Expression (New-Object System.Net.WebClient).DownloadString('https://get.scoop.sh')
        $env:Path = [System.Environment]::GetEnvironmentVariable("Path", "Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path", "User")
        Write-Host "[OK] Scoop встановлено!" -ForegroundColor Green
        Write-Host ""
    }
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
Write-Host "Починаю встановлення для Laravel..." -ForegroundColor Cyan
Write-Host ""

if (-not (Check-PHP)) {
    exit 1
}

Check-Scoop
Install-Composer
Install-MySQL

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  Встановлення Laravel завершено!" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "Встановлено:" -ForegroundColor Yellow
try { Write-Host "  Composer: $(composer --version 2>&1)" -ForegroundColor White } catch { Write-Host "  Composer: не встановлено" -ForegroundColor Red }
try { Write-Host "  MySQL:    $(mysql --version 2>&1)" -ForegroundColor White } catch { Write-Host "  MySQL:    не встановлено" -ForegroundColor Red }

Write-Host ""
Write-Host "Тепер ви можете працювати з Laravel (ЛР 6-7):" -ForegroundColor Yellow
Write-Host "  composer create-project laravel/laravel myproject" -ForegroundColor White
Write-Host ""
Write-Host "ВАЖЛИВО: Перезапустіть термінал для оновлення PATH!" -ForegroundColor Magenta
Write-Host ""
