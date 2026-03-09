<?php
/**
 * Завдання 4: Клонування об'єктів
 *
 * __clone() задає значення за замовчуванням при копіюванні
 */
require_once __DIR__ . '/layout.php';

// Клас Doctor з __clone() методом
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
    
    public function __clone(): void {
        $this->name = "Лікар";
        $this->specialization = "";
        $this->licenseNumber = "";
    }
}

// Оригінальний об'єкт (через конструктор)
$doctor3 = new Doctor('Максим Олійник', 'Хірург', 'LIC-2190');

// Клонуємо — __clone() задає значення за замовчуванням
$doctor4 = clone $doctor3;

ob_start();
?>

<div class="task-header">
    <h1>Клонування</h1>
    <p>Метод <code>__clone()</code> задає значення за замовчанням при копіюванні об'єкта</p>
</div>

<div class="code-block"><span class="code-comment">// Метод __clone() — викликається автоматично при clone</span>
<span class="code-keyword">public function</span> <span class="code-method">__clone</span>(): <span class="code-class">void</span>
{
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-string">'Лікар'</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">specialization</span> = <span class="code-string">''</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">licenseNumber</span> = <span class="code-string">''</span>;
}

<span class="code-comment">// Створюємо 4-й об'єкт через clone</span>
<span class="code-variable">$doctor4</span> = <span class="code-keyword">clone</span> <span class="code-variable">$doctor3</span>;</div>

<div class="section-divider">
    <span class="section-divider-text">Оригінал vs Клон</span>
</div>

<div class="comparison-wrapper">
    <div class="users-grid">
        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar avatar-amber">М</div>
                <div>
                    <div class="user-card-name"><?= htmlspecialchars($doctor3->name) ?></div>
                    <div class="user-card-label">$doctor3 <span class="user-card-badge badge-constructor">original</span></div>
                </div>
            </div>
            <div class="user-card-body">
                <div class="user-card-field">
                    <span class="user-card-field-label">name</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($doctor3->name) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">specialization</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($doctor3->specialization) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">licenseNumber</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($doctor3->licenseNumber) ?></span>
                </div>
            </div>
        </div>

        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar avatar-rose">Л</div>
                <div>
                    <div class="user-card-name"><?= htmlspecialchars($doctor4->name) ?></div>
                    <div class="user-card-label">$doctor4 <span class="user-card-badge badge-clone">clone</span></div>
                </div>
            </div>
            <div class="user-card-body">
                <div class="user-card-field">
                    <span class="user-card-field-label">name</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($doctor4->name) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">specialization</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($doctor4->specialization) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">licenseNumber</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($doctor4->licenseNumber) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-divider">
    <span class="section-divider-text">getInfo() порівняння</span>
</div>

<div class="info-output">
    <div class="info-output-header">Результат getInfo() для оригіналу та клону</div>
    <div class="info-output-body">
        <div class="info-output-row">
            <span class="info-output-label">$doctor3</span>
            <span class="info-output-text"><?= htmlspecialchars($doctor3->getInfo()) ?></span>
        </div>
        <div class="info-output-row">
            <span class="info-output-label">$doctor4</span>
            <span class="info-output-text"><?= htmlspecialchars($doctor4->getInfo()) ?></span>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 4', 'task4-body');
