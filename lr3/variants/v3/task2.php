<?php
/**
 * Завдання 2: Метод getInfo()
 *
 * Метод об'єкта Doctor, що виводить значення властивостей
 */
require_once __DIR__ . '/layout.php';

// Клас Doctor
class Doctor {
    public $name;
    public $specialization;
    public $licenseNumber;
    
    public function getInfo() {
        return "Лікар: {$this->name}, Спеціалізація: {$this->specialization}, Ліцензія: {$this->licenseNumber}";
    }
}

// Створюємо 3 об'єкти
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

$doctors = [$doctor1, $doctor2, $doctor3];
$labels = ['$doctor1', '$doctor2', '$doctor3'];

ob_start();
?>

<div class="task-header">
    <h1>Метод getInfo()</h1>
    <p>Виводить значення властивостей об'єкта</p>
</div>

<div class="code-block"><span class="code-comment">// Метод getInfo() повертає рядок з інформацією</span>
<span class="code-keyword">public function</span> <span class="code-method">getInfo</span>(): <span class="code-class">string</span>
{
    <span class="code-keyword">return</span> <span class="code-string">"Лікар: {\$this->name}, Спеціалізація: {\$this->specialization}, Ліцензія: {\$this->licenseNumber}"</span>;
}

<span class="code-comment">// Виклик для кожного об'єкта</span>
<span class="code-variable">$doctor1</span><span class="code-arrow">-></span><span class="code-method">getInfo</span>();</div>

<div class="section-divider">
    <span class="section-divider-text">Результат виклику</span>
</div>

<div class="info-output">
    <div class="info-output-header">getInfo() — вивід для кожного об'єкта</div>
    <div class="info-output-body">
        <?php foreach ($doctors as $i => $doctor): ?>
        <div class="info-output-row">
            <span class="info-output-label"><?= $labels[$i] ?></span>
            <span class="info-output-text"><?= htmlspecialchars($doctor->getInfo()) ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-divider">
    <span class="section-divider-text">Картки лікарів</span>
</div>

<div class="users-grid">
    <?php
    $avatars = ['avatar-indigo', 'avatar-green', 'avatar-amber'];
    $initials = ['А', 'Л', 'М'];
    foreach ($doctors as $i => $doctor):
    ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $avatars[$i] ?>"><?= $initials[$i] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($doctor->name) ?></div>
                <div class="user-card-label"><?= $labels[$i] ?>->getInfo()</div>
            </div>
        </div>
        <div class="user-card-body">
            <div class="user-card-field">
                <span class="user-card-field-label">name</span>
                <span class="user-card-field-value"><?= htmlspecialchars($doctor->name) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">specialization</span>
                <span class="user-card-field-value"><?= htmlspecialchars($doctor->specialization) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">licenseNumber</span>
                <span class="user-card-field-value"><?= htmlspecialchars($doctor->licenseNumber) ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 2', 'task2-body');
