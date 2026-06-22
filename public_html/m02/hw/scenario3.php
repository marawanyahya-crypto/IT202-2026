<?php
// copilot: disable
// @ts-nocheck
require_once "base.php";

$ucid = "mm3275"; // <-- set your ucid

// Don't edit the arrays below, they are used to test your code
$array1 = [42, -17, 89, -256, 1024, -4096, 50000, -123456];
$array2 = [3.14159265358979, -2.718281828459, 1.61803398875, -0.5772156649, 0.0000001, -1000000.0];
$array3 = [1.1, -2.2, 3.3, -4.4, 5.5, -6.6, 7.7, -8.8];
$array4 = ["123", "-456", "789.01", "-234.56", "0.00001", "-99999999"];
$array5 = [-1, 1, 2.0, -2.0, "3", "-3.0"];

function bePositive($arr, $arrayNumber)
{
    echo "<div class='problem-item'>";

    printScenario3ArrayInfo($arr, $arrayNumber);

    $output = array_fill(0, count($arr), null);

    // Start Solution Edits

    // mm3275 2026-06-22
    // Plan:
    // 1. Loop through every value in the array.
    // 2. Make the value positive.
    // 3. Preserve the original data type before saving it into output.

    foreach ($arr as $index => $value) {
        if (is_string($value)) {
            $output[$index] = ltrim($value, "-");
        } else {
            $output[$index] = abs($value);
        }
    }

    // End Solution Edits

    printScenario3Output($output);
    echo "</div>";
}

// Run the problem
printHeader($ucid, 3);
echo "<div class='scenario3-grid'>";

bePositive($array1, 1);
bePositive($array2, 2);
bePositive($array3, 3);
bePositive($array4, 4);
bePositive($array5, 5);

if(isset($_POST["array1"])){
    bePositive($_POST["array1"], 6);
}

echo "</div>";
printFooter($ucid, 3);
```
