# PHP Labs - Laravel Windows Setup (Composer + MySQL)
# Додаткове встановлення для ЛР 6-7. НЕ запускайте від імені адміністратора!
# Потребує PHP та Git (.\install-basic.ps1)

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
Write-Host "  PHP Labs - Встановлення Laravel" -ForegroundColor Cyan
Write-Host "  (Composer + MySQL для ЛР 6-7)" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""

function Test-Command {
    param($Command)
    return [bool](Get-Command -Name $Command -ErrorAction SilentlyContinue)
}

# Check PHP prerequisite
Write-Host ">>> Перевірка PHP..." -ForegroundColor Yellow
if (Test-Command "php") {
    Write-Host "[OK] PHP встановлено: $(php -v | Select-Object -First 1)" -ForegroundColor Green
    Write-Host ""
} else {
    Write-Host "[X] PHP не встановлено!" -ForegroundColor Red
    Write-Host "    Спочатку запустіть: .\install-basic.ps1" -ForegroundColor Yellow
    Write-Host ""
    exit 1
}

# Check Scoop
Write-Host ">>> Перевірка Scoop..." -ForegroundColor Yellow
if (Test-Command "scoop") {
    Write-Host "[OK] Scoop вже встановлено" -ForegroundColor Green
} else {
    Write-Host "    Встановлення Scoop..." -ForegroundColor Yellow
    Set-ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
    try {
        irm get.scoop.sh | iex
    } catch {
        Write-Host "    Перша спроба не вдалась, пробую альтернативний спосіб..." -ForegroundColor Yellow
        iex "& {$(irm get.scoop.sh)} -RunAsAdmin"
    }
    Write-Host "[OK] Scoop встановлено!" -ForegroundColor Green
}
Write-Host ""

# Composer
Write-Host ">>> Перевірка Composer..." -ForegroundColor Yellow
if (Test-Command "composer") {
    Write-Host "[OK] Composer вже встановлено: $(composer --version 2>&1)" -ForegroundColor Green
} else {
    Write-Host "    Встановлення Composer..." -ForegroundColor Yellow
    scoop install composer
    Write-Host "[OK] Composer встановлено!" -ForegroundColor Green
}
Write-Host ""

# MySQL
Write-Host ">>> Перевірка MySQL..." -ForegroundColor Yellow
if (Test-Command "mysql") {
    Write-Host "[OK] MySQL вже встановлено: $(mysql --version 2>&1)" -ForegroundColor Green
} else {
    Write-Host "    Встановлення MySQL..." -ForegroundColor Yellow
    scoop install mysql
    Write-Host "[OK] MySQL встановлено!" -ForegroundColor Green
}
Write-Host ""

# Summary
Write-Host "===================================" -ForegroundColor Cyan
Write-Host "  Встановлення Laravel завершено!" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "ВАЖЛИВО: Закрийте PowerShell та відкрийте нове вікно!" -ForegroundColor Magenta
Write-Host ""
Write-Host "Потім перевірте:" -ForegroundColor Yellow
Write-Host "  composer -V" -ForegroundColor White
Write-Host "  mysql --version" -ForegroundColor White
Write-Host ""
