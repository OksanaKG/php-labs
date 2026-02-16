# PHP Labs - Basic Windows Setup (PHP + Git)
# Для ЛР 1-5. НЕ запускайте від імені адміністратора!

# Check if running as admin
$isAdmin = ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
if ($isAdmin) {
    Write-Host "[!] Цей скрипт НЕ потребує прав адміністратора!" -ForegroundColor Red
    Write-Host "    Закрийте це вікно та відкрийте PowerShell звичайним способом:" -ForegroundColor Yellow
    Write-Host "    Win → PowerShell → Enter" -ForegroundColor White
    Write-Host ""
    exit 1
}

Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  PHP Labs - Базове встановлення" -ForegroundColor Cyan
Write-Host "  (PHP + Git для ЛР 1-5)" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""

function Test-Command {
    param($Command)
    return [bool](Get-Command -Name $Command -ErrorAction SilentlyContinue)
}

# Step 1: Execution Policy
Write-Host ">>> Налаштування ExecutionPolicy..." -ForegroundColor Yellow
Set-ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
Write-Host "[OK] ExecutionPolicy налаштовано" -ForegroundColor Green
Write-Host ""

# Step 2: Scoop
Write-Host ">>> Перевірка Scoop..." -ForegroundColor Yellow
if (Test-Command "scoop") {
    Write-Host "[OK] Scoop вже встановлено" -ForegroundColor Green
} else {
    Write-Host "    Встановлення Scoop..." -ForegroundColor Yellow
    try {
        irm get.scoop.sh | iex
    } catch {
        Write-Host "    Перша спроба не вдалась, пробую альтернативний спосіб..." -ForegroundColor Yellow
        iex "& {$(irm get.scoop.sh)} -RunAsAdmin"
    }
    Write-Host "[OK] Scoop встановлено!" -ForegroundColor Green
}
Write-Host ""

# Step 3: PHP
Write-Host ">>> Перевірка PHP..." -ForegroundColor Yellow
if (Test-Command "php") {
    Write-Host "[OK] PHP вже встановлено: $(php -v | Select-Object -First 1)" -ForegroundColor Green
} else {
    Write-Host "    Встановлення PHP..." -ForegroundColor Yellow
    scoop install php
    Write-Host "[OK] PHP встановлено!" -ForegroundColor Green
}
Write-Host ""

# Step 4: Git
Write-Host ">>> Перевірка Git..." -ForegroundColor Yellow
if (Test-Command "git") {
    Write-Host "[OK] Git вже встановлено: $(git --version)" -ForegroundColor Green
} else {
    Write-Host "    Встановлення Git..." -ForegroundColor Yellow
    scoop install git
    Write-Host "[OK] Git встановлено!" -ForegroundColor Green
}
Write-Host ""

# Summary
Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  Базове встановлення завершено!" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "ВАЖЛИВО: Закрийте PowerShell та відкрийте нове вікно!" -ForegroundColor Magenta
Write-Host ""
Write-Host "Потім перевірте:" -ForegroundColor Yellow
Write-Host "  php -v" -ForegroundColor White
Write-Host "  git --version" -ForegroundColor White
Write-Host "  php -S localhost:8000   # запуск сервера" -ForegroundColor White
Write-Host ""
