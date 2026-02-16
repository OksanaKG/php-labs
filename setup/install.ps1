# PHP Labs - Full Windows Setup (PHP + Git + Composer + MySQL)
# Для всіх ЛР (1-7). НЕ запускайте від імені адміністратора!

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
Write-Host "  PHP Labs - Повне встановлення" -ForegroundColor Cyan
Write-Host "  (PHP + Git + Composer + MySQL)" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Якщо вам потрібні тільки PHP + Git (ЛР 1-5):" -ForegroundColor Yellow
Write-Host "  .\install-basic.ps1" -ForegroundColor White
Write-Host ""

$answer = Read-Host "Продовжити повну установку? (y/n)"
if ($answer -ne "y" -and $answer -ne "Y") {
    Write-Host "Скасовано." -ForegroundColor Yellow
    exit 0
}
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

# Step 3: Install packages
foreach ($pkg in @("php", "git", "composer", "mysql")) {
    Write-Host ">>> Перевірка $pkg..." -ForegroundColor Yellow
    if (Test-Command $pkg) {
        Write-Host "[OK] $pkg вже встановлено" -ForegroundColor Green
    } else {
        Write-Host "    Встановлення $pkg..." -ForegroundColor Yellow
        scoop install $pkg
        Write-Host "[OK] $pkg встановлено!" -ForegroundColor Green
    }
    Write-Host ""
}

# Summary
Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  Повне встановлення завершено!" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "ВАЖЛИВО: Закрийте PowerShell та відкрийте нове вікно!" -ForegroundColor Magenta
Write-Host ""
Write-Host "Потім перевірте:" -ForegroundColor Yellow
Write-Host "  php -v" -ForegroundColor White
Write-Host "  git --version" -ForegroundColor White
Write-Host "  composer -V" -ForegroundColor White
Write-Host "  php -S localhost:8000   # запуск сервера" -ForegroundColor White
Write-Host ""
