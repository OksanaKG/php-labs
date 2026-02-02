# Проблема: Не запускається скрипт install.ps1 або install.sh

## Симптоми

- PowerShell або термінал виводить помилку на кшталт:
  - `Имя ".\install.ps1" не распознано как имя командлета...`
  - `No such file or directory: ./install.sh`

## Причина

Скрипт запускається не з тієї папки, де він знаходиться. PowerShell або Bash не бачить файл install.ps1/install.sh у поточній директорії.

## Рішення

1. Перейдіть у папку `setup` вашого проєкту:
   - Для Windows PowerShell:

     ```powershell
     cd шлях\до\php-labs\setup
     .\install.ps1
     ```

   - Для macOS/Linux:

     ```bash
     cd /шлях/до/php-labs/setup
     ./install.sh
     ```

2. Переконайтесь, що у цій папці дійсно є потрібний скрипт (перевірте через `ls` або `dir`).

---

Детальніше див. у [setup/README.md](../setup/README.md)
