<?php
require_once __DIR__.'/tasks/task4.php';
$hour = 14;
$timeOfDay = determineTimeOfDay($hour);
$styles = [
    "Ранок" => ["color" => "#fbbf24", "emoji" => "🌅", "bg" => "#fef3c7"],
    "День" => ["color" => "#3b82f6", "emoji" => "☀️", "bg" => "#dbeafe"],
    "Вечір" => ["color" => "#f97316", "emoji" => "🌆", "bg" => "#ffedd5"],
    "Ніч" => ["color" => "#1e3a5f", "emoji" => "🌙", "bg" => "#1e293b"],
];
$style = $styles[$timeOfDay] ?? ["color"=>"#333","emoji"=>"❓","bg"=>"#fff"];
$nightStyle = $timeOfDay === "Ніч" ? "color:white;background:{$style['bg']};" : "background:{$style['bg']};";
$content = '<div class="card" style="' . $nightStyle . '">
    <div class="emoji-large">'.$style['emoji'].'</div>
    <div class="time-display" style="color:'.$style['color'].';">'.sprintf("%02d:00", $hour).'</div>
    <div class="result-text">'.$timeOfDay.'</div>
    <p class="info" style="color:#666;">Функція: determineTimeOfDay('.$hour.') = "'.$timeOfDay.'"</p>
</div>';
require __DIR__.'/layout.php';
renderLayout($content);
