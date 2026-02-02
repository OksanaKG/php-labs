<?php
require_once __DIR__.'/tasks/task2.php';
$content = '<div class="poem">'.generatePoem().'</div>';
require __DIR__.'/layout.php';
renderLayout($content);