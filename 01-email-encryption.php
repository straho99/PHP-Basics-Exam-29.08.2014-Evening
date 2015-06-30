<?php
$recipient = $_GET['recipient'];
$subject = $_GET['subject'];
$body = $_GET['body'];
$key = $_GET['key'];
$message = "<p class='recipient'>" . htmlspecialchars($recipient). "</p>"
    . "<p class='subject'>" . htmlspecialchars($subject). "</p>"
    . "<p class='message'>" . htmlspecialchars($body). "</p>";
echo encryptText($message, $key);

function encryptText($text, $key) {
    $result = '|';
    $j = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        if ($j==strlen($key)) {
            $j = 0;
            $asciiChar = ord($text[$i]);
            $asciiKey = ord($key[$j]);
            $j++;
        } else {
            $asciiChar = ord($text[$i]);
            $asciiKey = ord($key[$j]);
            $j++;
        }
        $multipliedNumber = $asciiChar * $asciiKey;
        $hexNumber = dechex($multipliedNumber);
        $result .= $hexNumber . '|';
    }
    return $result;
}
?>