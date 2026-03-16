<?php

class RegformController extends PageController
{
    public function action_form(): void
    {
        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validate($old);

            if (empty($errors)) {
                $_SESSION['reg_success'] = true;
                $_SESSION['reg_data'] = [
                    'name' => is_string($old['name'] ?? '') ? trim($old['name']) : '',
                    'gender' => is_string($old['gender'] ?? '') ? trim($old['gender']) : '',
                    'birthdate' => isset($old['day'], $old['month'], $old['year']) 
                        ? sprintf('%04d-%02d-%02d', intval($old['year']), intval($old['month']), intval($old['day']))
                        : '',
                ];
                $this->redirect('regform/done');
                return;
            }
        }

        $this->render('regform/form', [
            'errors' => $errors,
            'old' => $old,
        ], 'Реєстрація');
    }

    public function action_done(): void
    {
        if (empty($_SESSION['reg_success'])) {
            $this->redirect('regform/form');
            return;
        }

        $data = $_SESSION['reg_data'] ?? [];
        unset($_SESSION['reg_success'], $_SESSION['reg_data']);

        $this->render('regform/done', ['regData' => $data], 'Реєстрація успішна');
    }

    private function validate(array $data): array
    {
        $errors = [];

        // Validate name
        $name = is_string($data['name'] ?? '') ? trim($data['name'] ?? '') : '';
        if ($name === '') {
            $errors['name'] = "Ім'я є обов'язковим.";
        }

        // Validate gender
        $gender = is_string($data['gender'] ?? '') ? trim($data['gender'] ?? '') : '';
        if ($gender === '') {
            $errors['gender'] = "Стать є обов'язковою.";
        } elseif (!in_array($gender, ['male', 'female'], true)) {
            $errors['gender'] = 'Некоректна стать.';
        }

        // Validate birthdate
        $day = (int)($data['day'] ?? 0);
        $month = (int)($data['month'] ?? 0);
        $year = (int)($data['year'] ?? 0);

        $dateErrors = [];
        if ($day < 1 || $day > 31) {
            $dateErrors[] = "Дата: день має бути від 1 до 31.";
        }
        if ($month < 1 || $month > 12) {
            $dateErrors[] = "Дата: місяць має бути від 1 до 12.";
        }
        if ($year < 1900 || $year > intval(date('Y'))) {
            $dateErrors[] = "Дата: рік має бути 4-значним числом.";
        }

        if (empty($dateErrors)) {
            // Check if date is valid
            if (!checkdate($month, $day, $year)) {
                $errors['birthdate'] = 'Некоректна дата народження.';
            } else {
                // Check age
                $birthDate = new DateTime(sprintf('%04d-%02d-%02d', $year, $month, $day));
                $today = new DateTime();
                $age = $today->diff($birthDate)->y;

                if ($gender === 'male' && $age < 21) {
                    $errors['birthdate'] = 'Не можна зареєструватися (вікове обмеження: для чоловіків мін. 21 рік).';
                } elseif ($gender === 'female' && $age < 18) {
                    $errors['birthdate'] = 'Не можна зареєструватися (вікове обмеження: для жінок мін. 18 років).';
                }
            }
        } else {
            $errors['birthdate'] = implode(' ', $dateErrors);
        }

        return $errors;
    }
}
