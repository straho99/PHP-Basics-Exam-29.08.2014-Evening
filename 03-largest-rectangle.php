<?php
$input = ($_GET['jsonTable']);
$text = json_decode($input);
$matrix = [];
$maxRectangleLocation = [];
$currentArea = 1;
$maxArea = 1;
$columns = count($text[0]);
$rows = count($text);
$count = 0;
for ($startRow = 0; $startRow < $rows; $startRow++) {
    $subArray = [];
    for ($startCol = 0; $startCol < $columns; $startCol++) {
        $subArray[] = false;

        for ($endRow = $startRow; $endRow < $rows; $endRow++) {
            for ($endCol = $startCol; $endCol < $columns; $endCol++) {
                $sides = [];
                for ($i = $startCol; $i <= $endCol; $i++) {
                    $sides[] = $text[$startRow][$i];
                    $sides[] = $text[$endRow][$i];

                }
                for ($i = $startRow; $i <= $endRow; $i++) {
                    $sides[] = $text[$i][$startCol];
                    $sides[] = $text[$i][$endCol];

                }
                if (count(array_unique($sides)) == 1) {
                    $currentArea = ($endRow - $startRow + 1) * ($endCol - $startCol + 1);
                    if ($currentArea > $maxArea) {
                        $maxArea = $currentArea;
                        $maxRectangleLocation = array(
                            'x1' => $startRow,
                            'x2' => $endRow,
                            'y1'=> $startCol,
                            'y2'=> $endCol
                        );
                        $count++;
                    }
                    $currentArea = 1;
                }
            }
        }

    }
    $matrix[] = $subArray;
}

if ($count==0) {
    $matrix[0][0]=true;
    echo "<table border='1' cellpadding='5'>";
    for ($i = 0; $i < $rows; $i++) {
        echo "<tr>";
        for ($j = 0; $j < $columns; $j++) {
            if ($matrix[$i][$j] == true) {
                echo "<td style='background:#CCC'>". htmlspecialchars($text[$i][$j]) . "</td>";
            } else {
                echo "<td>". htmlspecialchars($text[$i][$j]) . "</td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";
    die;
}

for ($i = $maxRectangleLocation['y1']; $i <= $maxRectangleLocation['y2']; $i++) {
    $matrix[$maxRectangleLocation['x1']][$i] = true;
    $matrix[$maxRectangleLocation['x2']][$i] = true;

}
for ($i = $maxRectangleLocation['x1']; $i <= $maxRectangleLocation['x2']; $i++) {
    $matrix[$i][$maxRectangleLocation['y1']] = true;
    $matrix[$i][$maxRectangleLocation['y2']] = true;

}

echo "<table border='1' cellpadding='5'>";
for ($i = 0; $i < $rows; $i++) {
    echo "<tr>";
    for ($j = 0; $j < $columns; $j++) {
        if ($matrix[$i][$j] == true) {
            echo "<td style='background:#CCC'>". htmlspecialchars($text[$i][$j]) . "</td>";
        } else {
            echo "<td>". htmlspecialchars($text[$i][$j]) . "</td>";
        }
    }
    echo "</tr>";
}
echo "</table>";
?>