<?php
// copilot: disable
// @ts-nocheck
require_once "base.php";

$ucid = "mm3275"; // <-- set your ucid

// Don't edit the arrays below, they are used to test your code
$array1 = ["hello world!", "php programming", "special@#$%^&characters", "numbers 123 456", "mIxEd CaSe InPut!"];
$array2 = ["hello world", "php programming", "this is a title case test", "capitalize every word", "mixEd CASE input"];
$array3 = ["  hello   world  ", "php    programming  ", "  extra    spaces  between   words   ",
    "      leading and trailing spaces      ", "multiple      spaces"];
$array4 = ["hello world", "php programming", "short", "a", "even"];

function transformText($arr, $arrayNumber) {
    echo "<div class='problem-item'>";

    printScenario4ArrayInfo($arr, $arrayNumber);

    $placeholderForModifiedPhrase = "";
    $placeholderForMiddleCharacters = "";

    foreach ($arr as $index => $text) {
        // Start Solution Edits

        // mm3275 2026-06-22
        // Plan:
        // 1. Remove symbols while keeping letters, numbers, and spaces.
        // 2. Trim extra outside spaces and replace duplicate spaces.
        // 3. Convert the cleaned phrase to title case.
        // 4. Find the middle characters for extra credit.

        $cleanedText = preg_replace("/[^a-zA-Z0-9 ]/", "", $text);
        $cleanedText = trim($cleanedText);
        $cleanedText = preg_replace("/\s+/", " ", $cleanedText);

        $placeholderForModifiedPhrase = ucwords(strtolower($cleanedText));

        $length = strlen($cleanedText);

        if ($length <= 2) {
            $placeholderForMiddleCharacters = "Not enough characters";
        } else {
            $middleSection = substr($cleanedText, 1, $length - 2);
            $middleLength = strlen($middleSection);

            if ($middleLength <= 3) {
                $placeholderForMiddleCharacters = $middleSection;
            } else {
                $start = floor(($middleLength - 3) / 2);
                $placeholderForMiddleCharacters = substr($middleSection, $start, 3);
            }
        }

        // End Solution Edits

        printScenario4Transformations($index, $placeholderForModifiedPhrase, $placeholderForMiddleCharacters);
    }

    echo "</div>";
}

// Run the problem
printHeader($ucid, 4);
echo "<div class='scenario4-grid'>";

transformText($array1, 1);
transformText($array2, 2);
transformText($array3, 3);
transformText($array4, 4);

if(isset($_POST["array1"])){
    transformText($_POST["array1"], 5);
}

echo "</div>";
printFooter($ucid, 4);
?>
```
