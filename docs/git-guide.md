# Git: Довідник команд

[← README](../README.md)

> **Початківцям:** спочатку прочитайте [Інструкцію для студентів](STUDENT_GUIDE.md) — там покроковий процес роботи. Цей файл — довідник для швидкого пошуку команд.

## Корисні ресурси

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Git Cheat Sheet](https://education.github.com/git-cheat-sheet-education.pdf)
- [Learn Git Branching](https://learngitbranching.js.org/) — інтерактивний тренажер

---

## Основні команди

### Гілки

```bash
git checkout -b lr1           # Створити нову гілку та перейти
git checkout lr2              # Перейти на існуючу гілку
git branch -a                 # Переглянути всі гілки
```

### Збереження змін

```bash
git status                    # Які файли змінено
git add task2.php             # Додати конкретний файл
git add .                     # Додати всі змінені файли
git commit -m "feat: опис"   # Створити коміт
git log --oneline             # Історія комітів
```

### Відправка та отримання

```bash
git push -u origin lr1        # Перший push нової гілки
git push                      # Наступні push
git pull                      # Отримати зміни з GitHub
```

### Перегляд змін

```bash
git diff                      # Незбережені зміни
git diff --staged             # Зміни в staging area
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

## Виправлення помилок

### Забули додати файл до коміту

```bash
git add forgotten_file.php
git commit --amend --no-edit
```

> **Увага:** `--amend` змінює останній коміт. Використовуйте тільки якщо ще НЕ робили `git push`. Після push — краще зробіть новий коміт.

### Помилка в повідомленні коміту

```bash
git commit --amend -m "feat: correct message"
```

> **Увага:** те саме правило — тільки до push.

### Скасувати останній коміт (зберігши зміни)

```bash
git reset --soft HEAD~1
```

> **Увага:** ця команда прибирає коміт, але зберігає ваші зміни. Файли не зникнуть. Використовуйте тільки до push.
