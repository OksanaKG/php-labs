#!/bin/bash

# PHP Labs - Laravel Setup Script
# Встановлення ПЗ для Laravel: Composer, MySQL/MariaDB

set -e

echo "==================================="
echo "  PHP Labs - Встановлення Laravel"
echo "==================================="
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

# Check PHP prerequisite
check_php() {
    echo ">>> Перевірка PHP (обов'язкова залежність)..."

    if command_exists php; then
        echo "✓ PHP встановлено: $(php -v | head -n 1)"
        echo ""
    else
        echo "✗ PHP не встановлено!"
        echo "  Спочатку запустіть: ./install-basic.sh"
        exit 1
    fi
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
                sudo apt update
                sudo apt install -y mariadb-server mariadb-client php-mysql php-zip
                sudo systemctl start mariadb
                sudo systemctl enable mariadb
                ;;
            redhat)
                sudo dnf install -y mariadb-server mariadb php-mysql php-zip
                sudo systemctl start mariadb
                sudo systemctl enable mariadb
                ;;
            *)
                echo "✗ Невідома ОС. Встановіть MySQL вручну."
                exit 1
                ;;
        esac
        echo "✓ MySQL/MariaDB встановлено: $(mysql --version 2>/dev/null || echo 'встановлено')"
    fi
    echo ""
}

# Main installation
echo "Починаю встановлення для Laravel..."
echo ""

check_php
install_composer
install_mysql

echo "==================================="
echo "  Встановлення Laravel завершено!"
echo "==================================="
echo ""
echo "Встановлено:"
echo "  Composer: $(composer --version 2>/dev/null || echo 'не встановлено')"
echo "  MySQL:    $(mysql --version 2>/dev/null || echo 'не встановлено')"
echo ""
echo "Тепер ви можете працювати з Laravel (ЛР 6-7):"
echo "  composer create-project laravel/laravel myproject"
echo ""
