<?php
$text = $_GET['text'];
$processedText = preg_replace_callback("/(?<![a-zA-Z])[A-Z]+(?![a-zA-Z])+/", function ($matches) {
    foreach ($matches as $match) {
        $reversedMatch = strrev($match);
        if ($reversedMatch == $match) {
            $reversedMatch = '';
            for ($i = 0; $i < strlen($match); $i++) {
                $reversedMatch .= $match[$i] . $match[$i];
            }
        }
    }
    return $reversedMatch;
}, $text);
echo "<p>" . htmlspecialchars($processedText) . "</p>";
?>