<?php
/**
 * Завдання 3: Конструктор
 *
 * Конструктор задає початкові значення name, specialization, licenseNumber
 */
require_once __DIR__ . '/layout.php';

// Клас Doctor з конструктором
 class Doctor {
    public $name;
    public $specialization;
    public $licenseNumber;
    
    public function __construct(string $name, string $specialization, string $licenseNumber) {
        $this->name = $name;
        $this->specialization = $specialization;
        $this->licenseNumber = $licenseNumber;
    }
    
    public function getInfo() {
        return "Лікар: {$this->name}, Спеціалізація: {$this->specialization}, Ліцензія: {$this->licenseNumber}";
    }
}

// Створюємо 3 об'єкти через конструктор
$doctor1 = new Doctor('Андрій Кравченко', 'Кардіолог', 'LIC-4521');
$doctor2 = new Doctor('Людмила Савченко', 'Терапевт', 'LIC-7834');
$doctor3 = new Doctor('Максим Олійник', 'Хірург', 'LIC-2190');

$doctors = [
    ['obj' => $doctor1, 'avatar' => 'avatar-indigo', 'initial' => 'А', 'var' => '$doctor1'],
    ['obj' => $doctor2, 'avatar' => 'avatar-green', 'initial' => 'Л', 'var' => '$doctor2'],
    ['obj' => $doctor3, 'avatar' => 'avatar-amber', 'initial' => 'М', 'var' => '$doctor3'],
];

ob_start();
?>

<div class="task-header">
    <h1>Конструктор</h1>
    <p>Початкові значення задаються одразу при створенні об'єкта</p>
</div>

<div class="code-block"><span class="code-comment">// Конструктор класу Doctor</span>
<span class="code-keyword">public function</span> <span class="code-method">__construct</span>(<span class="code-class">string</span> <span class="code-variable">$name</span>, <span class="code-class">string</span> <span class="code-variable">$specialization</span>, <span class="code-class">string</span> <span class="code-variable">$licenseNumber</span>)
{
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-variable">$name</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">specialization</span> = <span class="code-variable">$specialization</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">licenseNumber</span> = <span class="code-variable">$licenseNumber</span>;
}

<span class="code-comment">// Створення через конструктор</span>
<span class="code-variable">$doctor1</span> = <span class="code-keyword">new</span> <span class="code-class">Doctor</span>(<span class="code-string">'Андрій Кравченко'</span>, <span class="code-string">'Кардіолог'</span>, <span class="code-string">'LIC-4521'</span>);
<span class="code-variable">$doctor2</span> = <span class="code-keyword">new</span> <span class="code-class">Doctor</span>(<span class="code-string">'Людмила Савченко'</span>, <span class="code-string">'Терапевт'</span>, <span class="code-string">'LIC-7834'</span>);
<span class="code-variable">$doctor3</span> = <span class="code-keyword">new</span> <span class="code-class">Doctor</span>(<span class="code-string">'Максим Олійник'</span>, <span class="code-string">'Хірург'</span>, <span class="code-string">'LIC-2190'</span>);</div>

<div class="section-divider">
    <span class="section-divider-text">Об'єкти створені через конструктор</span>
</div>

<div class="users-grid">
    <?php foreach ($doctors as $data): ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $data['avatar'] ?>"><?= $data['initial'] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($data['obj']->name) ?></div>
                <div class="user-card-label"><?= $data['var'] ?> <span class="user-card-badge badge-constructor">constructor</span></div>
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

<div class="section-divider">
    <span class="section-divider-text">getInfo() для кожного</span>
</div>

<div class="info-output">
    <div class="info-output-header">Виклик getInfo() для об'єктів, створених через конструктор</div>
    <div class="info-output-body">
        <?php foreach ($doctors as $data): ?>
        <div class="info-output-row">
            <span class="info-output-label"><?= $data['var'] ?></span>
            <span class="info-output-text"><?= htmlspecialchars($data['obj']->getInfo()) ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 3', 'task3-body');
