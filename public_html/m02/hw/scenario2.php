<?php
// copilot: disable
// @ts-nocheck
require_once "base.php";

$ucid = "mm3275"; // <-- set your ucid

// Don't edit the arrays below, they are used to test your code
$array1 = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6];
$array2 = [1.0000001, 1.0000002, 1.0000003, 1.0000004, 1.0000005];
$array3 = [1.0 / 3.0, 2.0 / 3.0, 4.0 / 3.0, 8.0 / 3.0, 8.0 / 3.0];
$array4 = [1e16, 1.0, -1e16, 2.0, -2.0, 1e-16];
$array5 = [M_PI, M_E, sqrt(2), sqrt(3), sqrt(5), log(2), log10(3)];

function sumValues($arr, $arrayNumber)
{
    echo "<div class='problem-item'>";

    printScenario2ArrayInfo($arr, $arrayNumber);

    $total = 0;

    // Start Solution Edits

    // mm3275 2026-06-22
    // Plan:
    // 1. Loop through the array and add each value.
    // 2. Store the sum in $total.
    // 3. Format the result to exactly 2 decimal places.

    foreach ($arr as $value) {
        $total += $value;
    }

    $modifiedTotal = number_format($total, 2, ".", "");

    // End Solution Edits

    printScenario2Output($total, $modifiedTotal);
    echo "</div>";
}

// Run the problem
printHeader($ucid, 2);
echo "<div class='scenario2-grid'>";

sumValues($array1, 1);
sumValues($array2, 2);
sumValues($array3, 3);
sumValues($array4, 4);
sumValues($array5, 5);

if(isset($_POST["array1"])){
    sumValues($_POST["array1"], 6);
}

echo "</div>";
printFooter($ucid, 2);
```
