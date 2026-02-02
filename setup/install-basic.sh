#!/bin/bash

# PHP Labs - Basic Setup Script
# Встановлення базового ПЗ: PHP, Git

set -e

echo "==================================="
echo "  PHP Labs - Базове встановлення"
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
                sudo apt install -y php php-cli php-mbstring php-xml php-curl
                ;;
            redhat)
                sudo dnf install -y php php-cli php-mbstring php-xml php-curl
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

# Main installation
echo "Починаю базове встановлення..."
echo ""

install_homebrew
install_php
install_git

echo "==================================="
echo "  Базове встановлення завершено!"
echo "==================================="
echo ""
echo "Встановлено:"
echo "  PHP: $(php -v | head -n 1)"
echo "  Git: $(git --version)"
echo ""
echo "Тепер ви можете:"
echo "  1. Запускати PHP файли: php filename.php"
echo "  2. Запустити локальний сервер: php -S localhost:8000"
echo ""
echo "Для лабораторних 6-7 (Laravel) запустіть:"
echo "  ./install-laravel.sh"
echo ""
