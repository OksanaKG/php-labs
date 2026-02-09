<?php
/**
 * Shared layout template for LR1 variant task pages
 *
 * Features:
 * - Fixed compact header (50px)
 * - Test status in header
 * - Back button to index
 *
 * Usage:
 *   $config = require __DIR__.'/config.php';
 *   require_once __DIR__.'/tasks/taskX.php';
 *   $content = '...HTML...';
 *   require dirname(__DIR__).'/shared/layout.php';
 *   renderLayout($content, $config);
 */

// Use global helpers
require_once dirname(__DIR__, 3) . '/shared/helpers/test_helper.php';
require_once dirname(__DIR__, 3) . '/shared/helpers/dev_reload.php';

/**
 * Renders compact header status HTML with details button
 */
function renderHeaderStatus(array $results): string
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
function renderTestModal(array $results): string
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
 * Renders code modal HTML
 */
function renderCodeModal(string $taskFile, string $variantPath): string
{
    $filePath = $variantPath . '/tasks/' . str_replace('.php', '', basename($taskFile)) . '.php';

    if (!file_exists($filePath)) {
        return '';
    }

    $code = file_get_contents($filePath);

    $html = "<div id='code-modal' class='test-modal' onclick='closeCodeModalOnBackdrop(event)'>";
    $html .= "<div class='test-modal-content code-modal-content'>";
    $html .= "<div class='test-modal-header'>";
    $html .= "<h2>💻 Код / Завдання</h2>";
    $html .= "<button class='test-modal-close' onclick='toggleCodeModal()'>✕</button>";
    $html .= "</div>";
    $html .= "<pre class='task-code'><code>" . htmlspecialchars($code) . "</code></pre>";
    $html .= "</div></div>";

    return $html;
}

/**
 * Renders the full page layout with fixed header
 */
function renderLayout(string $content, array $config): void
{
    $variantName = $config['variantName'] ?? "Варіант";
    $lab = $config['lab'] ?? 'lr1';
    $labName = $config['labName'] ?? 'ЛР1';
    $tasks = $config['tasks'] ?? [];
    $variantPath = $config['variantPath'] ?? __DIR__;
    $currentTask = $config['currentTask'] ?? basename($_SERVER['SCRIPT_NAME']);

    $taskInfo = $tasks[$currentTask] ?? ['name' => 'Завдання', 'test' => null];
    $taskName = $taskInfo['name'];

    // Run tests automatically
    $testResults = ['status' => 'no_tests', 'passed' => 0, 'failed' => 0, 'total' => 0, 'details' => []];
    if (isset($taskInfo['test'])) {
        $testResults = runTaskTests($taskInfo['test'], $variantPath);
    }

    // Path to shared styles
    $sharedPath = '../shared';

    // Demo link for current task
    $variant = $config['variant'] ?? 'v1';
    $demoUrl = "/{$lab}/demo/{$currentTask}?from={$variant}";
    ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($taskName) ?> — <?= htmlspecialchars($labName) ?>, <?= htmlspecialchars($variantName) ?></title>
    <link rel="stylesheet" href="<?= $sharedPath ?>/style.css">
</head>
<body class="body-with-header">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
            <a href="index.php" class="header-btn">← Варіант</a>
            <a href="<?= htmlspecialchars($demoUrl) ?>" class="header-btn header-btn-demo">📖 Демо</a>
        </div>
        <div class="header-center">
            <?= renderHeaderStatus($testResults) ?>
            <button class="header-btn header-btn-code" onclick="toggleCodeModal()">Код</button>
        </div>
        <div class="header-right">
            <span class="header-variant-label"><?= htmlspecialchars($variantName) ?></span>
            <select class="header-task-select" onchange="if(this.value) location.href=this.value">
                <?php foreach ($tasks as $file => $info): ?>
                <option value="<?= htmlspecialchars($file) ?>" <?= $file === $currentTask ? 'selected' : '' ?>>
                    <?= htmlspecialchars($info['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </header>

    <div class="content-wrapper">
        <?= $content ?>
    </div>

    <?= renderTestModal($testResults) ?>
    <?= renderCodeModal($currentTask, $variantPath) ?>

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
    function toggleCodeModal() {
        const modal = document.getElementById('code-modal');
        if (modal) {
            modal.classList.toggle('open');
            document.body.classList.toggle('modal-open');
        }
    }
    function closeCodeModalOnBackdrop(e) {
        if (e.target.id === 'code-modal') {
            toggleCodeModal();
        }
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const testModal = document.getElementById('test-modal');
            const codeModal = document.getElementById('code-modal');
            if (testModal && testModal.classList.contains('open')) {
                toggleTestModal();
            }
            if (codeModal && codeModal.classList.contains('open')) {
                toggleCodeModal();
            }
        }
    });
    </script>
    <?= devReloadScript() ?>
</body>
</html>
<?php
}
