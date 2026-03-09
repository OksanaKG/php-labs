<?php
/**
 * Завдання 1: Створення класів та об'єктів
 *
 * Клас Doctor: name, specialization, licenseNumber
 */
require_once __DIR__ . '/layout.php';

// Клас Doctor
class Doctor {
    public $name;
    public $specialization;
    public $licenseNumber;
}

// Створюємо 3 об'єкти з довільними значеннями
$doctor1 = new Doctor();
$doctor1->name = 'Андрій Кравченко';
$doctor1->specialization = 'Кардіолог';
$doctor1->licenseNumber = 'LIC-4521';

$doctor2 = new Doctor();
$doctor2->name = 'Людмила Савченко';
$doctor2->specialization = 'Терапевт';
$doctor2->licenseNumber = 'LIC-7834';

$doctor3 = new Doctor();
$doctor3->name = 'Максим Олійник';
$doctor3->specialization = 'Хірург';
$doctor3->licenseNumber = 'LIC-2190';

$doctors = [
    ['obj' => $doctor1, 'avatar' => 'avatar-indigo', 'initial' => 'А'],
    ['obj' => $doctor2, 'avatar' => 'avatar-green', 'initial' => 'Л'],
    ['obj' => $doctor3, 'avatar' => 'avatar-amber', 'initial' => 'М'],
];

ob_start();
?>

<div class="task-header">
    <h1>Створення об'єктів</h1>
    <p>Клас <code>Doctor</code> з властивостями: name, specialization, licenseNumber</p>
</div>

<div class="code-block"><span class="code-comment">// Створюємо об'єкт та задаємо властивості</span>
<span class="code-keyword">class</span> <span class="code-class">Doctor</span> {
    <span class="code-keyword">public</span> <span class="code-variable">$name</span>;
    <span class="code-keyword">public</span> <span class="code-variable">$specialization</span>;
    <span class="code-keyword">public</span> <span class="code-variable">$licenseNumber</span>;
}

<span class="code-variable">$doctor1</span> = <span class="code-keyword">new</span> <span class="code-class">Doctor</span>();
<span class="code-variable">$doctor1</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-string">'Андрій Кравченко'</span>;
<span class="code-variable">$doctor1</span><span class="code-arrow">-></span><span class="code-method">specialization</span> = <span class="code-string">'Кардіолог'</span>;
<span class="code-variable">$doctor1</span><span class="code-arrow">-></span><span class="code-method">licenseNumber</span> = <span class="code-string">'LIC-4521'</span>;</div>

<div class="section-divider">
    <span class="section-divider-text">3 об'єкти</span>
</div>

<div class="users-grid">
    <?php foreach ($doctors as $i => $data): ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $data['avatar'] ?>"><?= $data['initial'] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($data['obj']->name) ?></div>
                <div class="user-card-label">Об'єкт #<?= $i + 1 ?></div>
            </div>
        </div>
        <div class="user-card-body">
            <div class="user-card-field">
                <span class="user-card-field-label">name</span>
                <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->name) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">specialization</span>
                <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->specialization) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">licenseNumber</span>
                <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->licenseNumber) ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 1', 'task1-body');
