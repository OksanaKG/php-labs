# Git: Короткий посібник

[← README](../README.md)

## Корисні ресурси

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Git Cheat Sheet](https://education.github.com/git-cheat-sheet-education.pdf)
- [Learn Git Branching](https://learngitbranching.js.org/) — інтерактивний тренажер

---

## Початкове налаштування

```bash
# Налаштувати ім'я та email (обов'язково!)
git config user.name "Прізвище Ім'я"
git config user.email "your.email@ztu.edu.ua"

# Перевірити налаштування
git config user.name
git config user.email
```

---

## Основні команди

### Клонування репозиторію

```bash
git clone https://github.com/username/repo.git
cd repo
```

### Створення та перемикання гілок

```bash
# Створити нову гілку та перейти на неї
git checkout -b lr1

# Перейти на існуючу гілку
git checkout lr2

# Переглянути всі гілки
git branch -a
```

### Збереження змін (commit)

```bash
# Переглянути статус (які файли змінено)
git status

# Додати файли до коміту
git add task2.php task3.php    # конкретні файли
git add .                       # всі змінені файли

# Створити коміт
git commit -m "feat: task2 - formatted text output"

# Переглянути історію комітів
git log --oneline
```

### Відправка на сервер (push)

```bash
# Перша відправка гілки
git push -u origin lr1

# Наступні відправки
git push
```

### Отримання змін (pull)

```bash
git pull
```

---

## Типовий робочий процес

```bash
# 1. Створити гілку для лабораторної
git checkout -b lr1

# 2. Виконати завдання та зберегти
git add task2.php
git commit -m "feat: task2 - formatted text output"

# 3. Виконати наступне завдання
git add task3.php
git commit -m "feat: task3 - currency converter"

# 4. Відправити на GitHub
git push -u origin lr1
```

---

## Формат коміт-повідомлень

```text
<type>: <short description>
```

| Тип | Опис |
|-----|------|
| `feat` | Нова функціональність |
| `fix` | Виправлення помилки |
| `docs` | Документація |
| `refactor` | Рефакторинг коду |

**Приклади:**

```text
feat: task3 - currency converter
fix: task4 - correct season calculation
docs: add README with setup instructions
```

---

## Часті помилки та рішення

### Забули додати файли до коміту

```bash
git add forgotten_file.php
git commit --amend --no-edit
```

### Помилка в повідомленні коміту

```bash
git commit --amend -m "feat: correct message"
```

### Скасувати останній коміт (зберігши зміни)

```bash
git reset --soft HEAD~1
```

### Переглянути зміни перед комітом

```bash
git diff              # незбережені зміни
git diff --staged     # зміни в staging area
```
