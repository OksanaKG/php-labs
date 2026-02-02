# Налаштування середовища розробки

[← Повернутися до основної документації](../README.md) | [CLAUDE.md](../CLAUDE.md)

Інструкції для встановлення необхідного програмного забезпечення на різних платформах.

## Скрипти автоматичної установки

| Скрипт        | Платформа   | Опис                                                                                  |
| ------------- | ----------- | ------------------------------------------------------------------------------------- |
| `install.ps1` | Windows     | PowerShell скрипт. Використовує Chocolatey для встановлення PHP, Composer, MySQL, Git |
| `install.sh`  | macOS/Linux | Bash скрипт. Використовує Homebrew (macOS) або apt/dnf (Linux)                        |

---

## Windows

### Автоматично (скрипт PowerShell)

1. Відкрийте PowerShell **від імені адміністратора**:
   - Натисніть `Win + S` і введіть `PowerShell`.
   - У списку результатів знайдіть "Windows PowerShell".
   - Клацніть правою кнопкою миші та виберіть **Запустити від імені адміністратора** (Run as administrator).

2. Дозвольте виконання скриптів:

   ```powershell
   Set-ExecutionPolicy RemoteSigned -Scope CurrentUser
   ```

3. Запустіть скрипт:

   > **Важливо:** Перед запуском переконайтесь, що ви знаходитеся у папці `setup`. Якщо ви бачите помилку "не распознано как имя командлета...", це означає, що PowerShell відкрито не в тій папці. Виконайте:

   ```powershell
   cd шлях\до\php-labs\setup
   .\install.ps1
   ```

### Варіант 1: WSL (рекомендовано)

1. Відкрийте PowerShell як адміністратор і виконайте:

```powershell
wsl --install
```

1. Перезавантажте комп'ютер

2. Відкрийте Ubuntu (WSL) та виконайте:

```bash
cd /path/to/php-labs/setup
chmod +x install.sh
./install.sh
```

### Варіант 2: Chocolatey

1. Встановіть [Chocolatey](https://chocolatey.org/install) (в PowerShell як адміністратор):

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force
[System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
```

1. Встановіть PHP, Composer та MySQL:

```powershell
choco install php composer mysql -y
```

1. Перезапустіть термінал та перевірте:

```powershell
php -v
composer -V
mysql --version
```

### Варіант 3: XAMPP

1. Завантажте [XAMPP](https://www.apachefriends.org/download.html)
2. Встановіть з компонентами: Apache, MySQL, PHP
3. Додайте PHP до PATH: `C:\xampp\php`
4. Встановіть Composer окремо: [getcomposer.org](https://getcomposer.org/download/)

---

## macOS

### Автоматично (скрипт)

```bash
cd setup
chmod +x install.sh
./install.sh
```

### Вручну (Homebrew)

1. Встановіть Homebrew (якщо ще не встановлено):

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

1. Встановіть PHP, Composer та MySQL:

```bash
brew install php composer mysql
brew services start mysql
```

1. Перевірте:

```bash
php -v
composer -V
mysql --version
```

---

## Linux

### Автоматично (скрипт)

```bash
cd setup
chmod +x install.sh
./install.sh
```

### Ubuntu/Debian

```bash
sudo apt update
sudo apt install -y php php-cli php-mbstring php-xml php-curl php-mysql php-zip
sudo apt install -y composer
sudo apt install -y mariadb-server mariadb-client
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

### Fedora/RHEL

```bash
sudo dnf install -y php php-cli php-mbstring php-xml php-curl php-mysql php-zip
sudo dnf install -y composer
sudo dnf install -y mariadb-server mariadb
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

---

## Перевірка встановлення

Після встановлення виконайте:

```bash
php -v          # PHP 8.x
composer -V     # Composer version 2.x
mysql --version # mysql Ver 8.x або MariaDB
```

## Запуск проєкту

```bash
# Перейти в папку проєкту
cd php-labs

# Запустити PHP файл
php filename.php

# Запустити локальний сервер
php -S localhost:8000
```

Відкрийте в браузері: <http://localhost:8000>

---

## Необхідне ПЗ

- PHP 8.x
- Composer
- MySQL/MariaDB
- Git
