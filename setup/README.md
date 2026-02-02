# Налаштування середовища розробки

[← Повернутися до основної документації](../README.md)

---

## Необхідне ПЗ

| ПЗ              | ЛР 1-5 (базове) | ЛР 6-7 (Laravel) |
| --------------- | :-------------: | :--------------: |
| PHP 8.x         |        ✓        |        ✓         |
| Git             |        ✓        |        ✓         |
| Composer        |                 |        ✓         |
| MySQL / MariaDB |                 |        ✓         |

---

## Швидкий старт

Оберіть вашу операційну систему:

- [Windows](#-windows)
- [macOS / Linux](#-macos--linux)

---

## 🪟 Windows

### Базове встановлення (ЛР 1-5)

Відкрийте **PowerShell** та виконайте:

```powershell
cd setup
.\install-basic.ps1
```

### Встановлення для Laravel (ЛР 6-7)

```powershell
cd setup
.\install-laravel.ps1
```

### Повне встановлення (все разом)

```powershell
cd setup
.\install.ps1
```

### ⚠️ Можливі проблеми

**Помилка виконання скриптів:**

```powershell
Set-ExecutionPolicy RemoteSigned -Scope CurrentUser
```

**"Кракозябри" в консолі:**
Переконайтесь, що файл збережено у кодуванні **UTF-8 без BOM**.

### Альтернативні варіанти для Windows

<details>
<summary><b>WSL (Windows Subsystem for Linux) — рекомендовано</b></summary>

```powershell
wsl --install
```

Після перезавантаження відкрийте Ubuntu та використовуйте bash скрипти (див. macOS / Linux).

</details>

<details>
<summary><b>XAMPP</b></summary>

1. Завантажте [XAMPP](https://www.apachefriends.org/download.html)
2. Встановіть з компонентами: Apache, MySQL, PHP
3. Додайте PHP до PATH: `C:\xampp\php`

</details>

---

## 🍎 macOS / Linux

### Базове встановлення (ЛР 1-5)

```bash
cd setup
chmod +x install-basic.sh
./install-basic.sh
```

### Встановлення для Laravel (ЛР 6-7)

```bash
cd setup
chmod +x install-laravel.sh
./install-laravel.sh
```

### Повне встановлення (все разом)

```bash
cd setup
chmod +x install.sh
./install.sh
```

### Ручне встановлення

<details>
<summary><b>macOS (Homebrew)</b></summary>

```bash
# Базове
brew install php git

# Для Laravel
brew install composer mysql
brew services start mysql
```

</details>

<details>
<summary><b>Ubuntu / Debian</b></summary>

```bash
# Базове
sudo apt update
sudo apt install -y php php-cli php-mbstring php-xml php-curl git

# Для Laravel
sudo apt install -y composer mariadb-server mariadb-client php-mysql php-zip
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

</details>

<details>
<summary><b>Fedora / RHEL</b></summary>

```bash
# Базове
sudo dnf install -y php php-cli php-mbstring php-xml php-curl git

# Для Laravel
sudo dnf install -y composer mariadb-server mariadb php-mysql php-zip
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

</details>

---

## Перевірка встановлення

```bash
# Базове
php -v          # PHP 8.x
git --version   # git version 2.x

# Laravel
composer -V     # Composer version 2.x
mysql --version # mysql Ver 8.x або MariaDB
```

---

## Запуск проєкту

Див. [docs/running-project.md](../docs/running-project.md)
