#!/bin/bash

# PHP Labs - Full Setup Script
# Повне встановлення всього необхідного ПЗ

set -e

echo "==================================="
echo "  PHP Labs - Повне встановлення"
echo "==================================="
echo ""
echo "Цей скрипт встановить все необхідне ПЗ:"
echo "  - PHP 8.x"
echo "  - Git"
echo "  - Composer"
echo "  - MySQL/MariaDB"
echo ""
echo "Якщо вам потрібна тільки базова установка (ЛР 1-5):"
echo "  ./install-basic.sh"
echo ""
echo "Продовжити повну установку? (y/n)"
read -r answer
if [[ "$answer" != "y" && "$answer" != "Y" ]]; then
    echo "Скасовано. Для базової установки: ./install-basic.sh"
    exit 0
fi
echo ""

# Detect OS
OS="unknown"
if [[ "$OSTYPE" == "darwin"* ]]; then
    OS="macos"
elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
    if [ -f /etc/debian_version ]; then
        OS="debian"
    elif [ -f /etc/redhat-release ]; then
        OS="redhat"
    fi
fi

echo "Виявлена ОС: $OS"
echo ""

# Function to check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Install Homebrew (macOS only)
install_homebrew() {
    if [[ "$OS" == "macos" ]] && ! command_exists brew; then
        echo ">>> Встановлення Homebrew..."
        /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
        echo ""
    fi
}

# Install PHP
install_php() {
    echo ">>> Перевірка PHP..."

    if command_exists php; then
        echo "✓ PHP вже встановлено: $(php -v | head -n 1)"
    else
        echo "  Встановлення PHP..."
        case $OS in
            macos)
                brew install php
                ;;
            debian)
                sudo apt update
                sudo apt install -y php php-cli php-mbstring php-xml php-curl php-mysql php-zip
                ;;
            redhat)
                sudo dnf install -y php php-cli php-mbstring php-xml php-curl php-mysql php-zip
                ;;
            *)
                echo "✗ Невідома ОС. Встановіть PHP вручну."
                exit 1
                ;;
        esac
        echo "✓ PHP встановлено: $(php -v | head -n 1)"
    fi
    echo ""
}

# Install Git
install_git() {
    echo ">>> Перевірка Git..."

    if command_exists git; then
        echo "✓ Git вже встановлено: $(git --version)"
    else
        echo "  Встановлення Git..."
        case $OS in
            macos)
                brew install git
                ;;
            debian)
                sudo apt install -y git
                ;;
            redhat)
                sudo dnf install -y git
                ;;
            *)
                echo "✗ Невідома ОС. Встановіть Git вручну."
                exit 1
                ;;
        esac
        echo "✓ Git встановлено: $(git --version)"
    fi
    echo ""
}

# Install Composer
install_composer() {
    echo ">>> Перевірка Composer..."

    if command_exists composer; then
        echo "✓ Composer вже встановлено: $(composer --version)"
    else
        echo "  Встановлення Composer..."
        case $OS in
            macos)
                brew install composer
                ;;
            debian|redhat)
                php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                php composer-setup.php
                php -r "unlink('composer-setup.php');"
                sudo mv composer.phar /usr/local/bin/composer
                ;;
            *)
                echo "✗ Невідома ОС. Встановіть Composer вручну."
                exit 1
                ;;
        esac
        echo "✓ Composer встановлено: $(composer --version)"
    fi
    echo ""
}

# Install MySQL/MariaDB
install_mysql() {
    echo ">>> Перевірка MySQL/MariaDB..."

    if command_exists mysql; then
        echo "✓ MySQL вже встановлено: $(mysql --version)"
    else
        echo "  Встановлення MySQL/MariaDB..."
        case $OS in
            macos)
                brew install mysql
                brew services start mysql
                ;;
            debian)
                sudo apt install -y mariadb-server mariadb-client
                sudo systemctl start mariadb
                sudo systemctl enable mariadb
                ;;
            redhat)
                sudo dnf install -y mariadb-server mariadb
                sudo systemctl start mariadb
                sudo systemctl enable mariadb
                ;;
            *)
                echo "✗ Невідома ОС. Встановіть MySQL вручну."
                exit 1
                ;;
        esac
        echo "✓ MySQL/MariaDB встановлено"
    fi
    echo ""
}

# Main installation
echo "Починаю повне встановлення..."
echo ""

install_homebrew
install_php
install_git
install_composer
install_mysql

echo "==================================="
echo "  Повне встановлення завершено!"
echo "==================================="
echo ""
echo "Встановлено:"
echo "  PHP:      $(php -v | head -n 1)"
echo "  Git:      $(git --version)"
echo "  Composer: $(composer --version 2>/dev/null || echo 'не встановлено')"
echo "  MySQL:    $(mysql --version 2>/dev/null || echo 'не встановлено')"
echo ""
echo "Тепер ви можете:"
echo "  php filename.php        # запустити PHP файл"
echo "  php -S localhost:8000   # локальний сервер"
echo ""
