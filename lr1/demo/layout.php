<?php
/**
 * Shared layout template for LR1 demo task pages
 *
 * Features:
 * - Fixed compact header (50px)
 * - Link back to variant if came from one (?from=vN)
 * - Test status display
 *
 * Usage:
 *   require_once __DIR__.'/layout.php';
 *   $content = '...HTML...';
 *   renderDemoLayout($content, $taskName, $bodyClass);
 */

// Use global helpers
require_once dirname(__DIR__, 2) . '/shared/helpers/test_helper.php';
require_once dirname(__DIR__, 2) . '/shared/helpers/dev_reload.php';

/**
 * Renders compact header status HTML with details button
 */
function renderDemoHeaderStatus(array $results): string
{
    $statusConfig = [
        'passed' => ['icon' => '✅', 'text' => 'Виконано', 'class' => 'header-status-passed'],
        'not_implemented' => ['icon' => '❌', 'text' => 'Не виконано', 'class' => 'header-status-failed'],
        'partial' => ['icon' => '⚠️', 'text' => 'Частково', 'class' => 'header-status-partial'],
        'no_tests' => ['icon' => '❓', 'text' => 'Немає тестів', 'class' => 'header-status-failed'],
    ];

    $config = $statusConfig[$results['status']] ?? $statusConfig['no_tests'];
    $score = $results['total'] > 0 ? "{$results['passed']}/{$results['total']}" : '';
    $percent = $results['total'] > 0 ? round(($results['passed'] / $results['total']) * 100) . '%' : '';

    $html = "<div class='header-status {$config['class']}'>"
        . "<span class='header-status-icon'>{$config['icon']}</span>"
        . "<span>{$config['text']}</span>"
        . ($score ? "<span class='header-status-score'>{$score} {$percent}</span>" : '')
        . "</div>";

    // Add results button if there are tests
    if ($results['total'] > 0) {
        $html .= "<button class='header-btn header-btn-details' onclick='toggleTestModal()'>Результати</button>";
    }

    return $html;
}

/**
 * Renders test details modal HTML
 */
function renderDemoTestModal(array $results): string
{
    if (empty($results['details'])) {
        return '';
    }

    $html = "<div id='test-modal' class='test-modal' onclick='closeModalOnBackdrop(event)'>";
    $html .= "<div class='test-modal-content'>";
    $html .= "<div class='test-modal-header'>";
    $html .= "<h2>Результати тестів ({$results['passed']}/{$results['total']})</h2>";
    $html .= "<button class='test-modal-close' onclick='toggleTestModal()'>✕</button>";
    $html .= "</div>";
    $html .= "<ul class='test-list'>";

    foreach ($results['details'] as $detail) {
        $class = $detail['passed'] ? 'test-item-passed' : 'test-item-failed';
        $icon = $detail['passed'] ? '✓' : '✗';
        $html .= "<li class='{$class}'>";
        $html .= "<span>{$icon}</span> " . htmlspecialchars($detail['name']);
        if (!$detail['passed'] && $detail['error']) {
            $html .= "<br><small class='test-error'>" . htmlspecialchars($detail['error']) . "</small>";
        }
        $html .= "</li>";
    }

    $html .= "</ul>";
    $html .= "</div></div>";

    return $html;
}

/**
 * Renders the full demo page layout with fixed header
 *
 * @param string $content HTML content for the page
 * @param string $taskName Task name for title (e.g., "Завдання 3")
 * @param string $bodyClass CSS class for body (e.g., "task3-body")
 * @param string|null $testName Test name to run (e.g., "task3"), null to skip tests
 */
function renderDemoLayout(string $content, string $taskName, string $bodyClass = '', ?string $testName = null): void
{
    // Check if came from a variant
    $fromVariant = $_GET['from'] ?? null;
    $currentTask = basename($_SERVER['SCRIPT_NAME']);
    $fromParam = $fromVariant ? '?from=' . htmlspecialchars($fromVariant) : '';

    // Demo tasks list for selector
    $demoTasks = [
        'task2.php' => 'Завдання 2',
        'task3.php' => 'Завдання 3',
        'task4.php' => 'Завдання 4',
        'task5.php' => 'Завдання 5',
        'task6.php' => 'Завдання 6',
        'task7_table.php' => 'Завдання 7.1',
        'task7_squares.php' => 'Завдання 7.2',
    ];

    // Build variant URL if came from one
    $variantUrl = null;
    if ($fromVariant && preg_match('/^v\d+$/', $fromVariant)) {
        $variantUrl = "/lr1/variants/{$fromVariant}/{$currentTask}";
    }

    // Run tests if test name provided
    $testResults = ['status' => 'no_tests', 'passed' => 0, 'failed' => 0, 'total' => 0, 'details' => []];
    if ($testName) {
        $testResults = runTaskTests($testName, __DIR__);
    }
    ?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($taskName) ?> — Демо ЛР1</title>
    <link rel="stylesheet" href="demo.css">
</head>

<body class="body-with-header <?= htmlspecialchars($bodyClass) ?>">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
            <a href="index.php<?= $fromVariant ? '?from=' . htmlspecialchars($fromVariant) : '' ?>" class="header-btn">←
                Демо</a>
            <?php if ($variantUrl): ?>
            <a href="<?= htmlspecialchars($variantUrl) ?>" class="header-btn header-btn-variant">← Варіант
                <?= htmlspecialchars(substr($fromVariant, 1)) ?></a>
            <?php endif; ?>
        </div>
        <div class="header-center">
            <?= renderDemoHeaderStatus($testResults) ?>
        </div>
        <div class="header-right">
            <span class="header-variant-label">Демо</span>
            <select class="header-task-select" onchange="if(this.value) location.href=this.value">
                <?php foreach ($demoTasks as $file => $name): ?>
                <option value="<?= htmlspecialchars($file . $fromParam) ?>"
                    <?= $file === $currentTask ? 'selected' : '' ?>>
                    <?= htmlspecialchars($name) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </header>

    <div class="content-wrapper">
        <?= $content ?>
    </div>

    <?= renderDemoTestModal($testResults) ?>

    <script>
    function toggleTestModal() {
        const modal = document.getElementById('test-modal');
        if (modal) {
            modal.classList.toggle('open');
            document.body.classList.toggle('modal-open');
        }
    }

    function closeModalOnBackdrop(e) {
        if (e.target.id === 'test-modal') {
            toggleTestModal();
        }
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('test-modal');
            if (modal && modal.classList.contains('open')) {
                toggleTestModal();
            }
        }
    });
    </script>
    <?= devReloadScript() ?>
</body>

</html>
<?php
}