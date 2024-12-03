<?php

// @phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

/**
 * A script to automate the creation of a new Advent of Code day.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-02 17:05:38
 * @Last Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last Modified time: 2024-12-02 17:45:34
 *
 * @package Aoc
 */

use RuntimeException;

/**
 * Generates the files and updates required for a new Advent of Code day.
 *
 * @param int    $day  The day number (e.g., 3 for Day 03).
 * @param string $name The name of the day's challenge.
 *
 * @return void
 */
function generateNewDay(int $day, string $name): void
{
    $dayFormatted = sprintf('%02d', $day); // Format day as "01", "02", etc.
    $dayPhpFile = "src/Day{$dayFormatted}.php";
    $dayDataFile = "src/Day{$dayFormatted}.data";
    $dayTestFile = "tests/Unit/Day{$dayFormatted}Test.php";
    $dayTestDataFile = "tests/Unit/Day{$dayFormatted}Sample.data";
    $workflowFile = ".github/workflows/Day-{$dayFormatted}.yml";
    $readmeFile = "README.md";
    $currentDateTime = date('Y-m-d H:i:s');

    // Create DayXX.php file
    $phpTemplate = <<<PHP
<?php

/**
 * Unit tests for the Advent of Code Day {dayFormatted} solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   {$currentDateTime}
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: {$currentDateTime}
 *
 * @package Aoc
 */

namespace Aoc;

class Day{$dayFormatted} extends AbstractDay
{
    public function solvePart1(array \$lines): int
    {
        // TODO: Implement solution for Part 1
        return 0;
    }

    public function solvePart2(array \$lines): int
    {
        // TODO: Implement solution for Part 2
        return 0;
    }

    public function solve(): array
    {
        \$lines = explode("\\n", \$this->getInputString());
        return [
            "Part 1" => \$this->solvePart1(\$lines),
            "Part 2" => \$this->solvePart2(\$lines)
        ];
    }
}
PHP;

    file_put_contents($dayPhpFile, $phpTemplate);

    // Create DayXX.data file
    file_put_contents($dayDataFile, "");

    // Create DayXXTest.php file
    $testTemplate = <<<PHP
<?php

/**
 * Unit tests for the Advent of Code Day {dayFormatted} solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   {$currentDateTime}
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: {$currentDateTime}
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day{$dayFormatted};
use PHPUnit\Framework\TestCase;

final class Day{$dayFormatted}Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        \$dayPuzzle = new Day{$dayFormatted}();
        \$input = explode("\\n", Helper::getSampleData('Day{$dayFormatted}Sample.data'));

        \$this->assertSame(\$dayPuzzle->solvePart1(\$input), 11);
    }

    public function testPart2ExampleInput(): void
    {
        \$dayPuzzle = new Day{$dayFormatted}();
        \$input = explode("\\n", Helper::getSampleData('Day{$dayFormatted}Sample.data'));

        \$this->assertSame(\$dayPuzzle->solvePart2(\$input), 31);
    }
}
PHP;

    file_put_contents($dayTestFile, $testTemplate);

    // Create DayXXSample.data file
    file_put_contents($dayTestDataFile, "");

    // Create GitHub Workflow file
    $workflowTemplate = <<<YAML
name: Day-{$dayFormatted}
on:
  workflow_dispatch:
  push:
    paths:
      - "**{$dayFormatted}*"
jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: amplium/git-crypt-action@master
        with:
          key_encoded: \${{ secrets.GIT_CRYPT_KEY }}
      - uses: php-actions/composer@v6
      - name: Run
        run: php src/main.php {$dayFormatted} -b
YAML;
    file_put_contents($workflowFile, $workflowTemplate);

    // Update README.md
    // @phpcs:disable Generic.Files.LineLength
    $newRow = sprintf(
        "| %s | %s | [src/Day%s.php](./src/Day%s.php) | `TBD` | " .
        "[![Day-%s](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-%s.yml/badge.svg?branch=main)]" .
        "(https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-%s.yml?query=branch%%3Amain) |\n",
        $dayFormatted,
        $name,
        $dayFormatted,
        $dayFormatted,
        $dayFormatted,
        $dayFormatted,
        $dayFormatted
    );

    $readmeContent = file_get_contents($readmeFile);

    if ($readmeContent === false) {
        throw new RuntimeException("Error: Failed to read {$readmeFile}");
    }

    // Locate the start of the solutions table
    $tableStart = strpos($readmeContent, "## Solutions");

    if ($tableStart === false) {
        throw new RuntimeException("Error: Could not locate the solutions table in README.md.");
    }

    // Locate the next "##" header after the solutions table
    $nextHeader = strpos($readmeContent, "##", $tableStart + 1);
    if ($nextHeader === false) {
        // No other headers; assume the table extends to the end of the file
        $tableContent = substr($readmeContent, $tableStart);
    } else {
        // Extract the content of the solutions table
        $tableContent = substr($readmeContent, $tableStart, $nextHeader - $tableStart);
    }

    // Find the last occurrence of a newline within the table content
    $lastNewline = strrpos($tableContent, "\n");

    if ($lastNewline === false) {
        throw new RuntimeException("Error: Could not locate the end of the table in README.md.");
    }

    // Calculate the actual position in the full file
    $insertPosition = $tableStart + $lastNewline + 1; // +1 to place the new row on a new line

    // Insert the new row after the last row
    $updatedContent = substr_replace($readmeContent, $newRow, $insertPosition, 0);

    // Write the updated content back to the README file
    if (file_put_contents($readmeFile, $updatedContent) === false) {
        throw new RuntimeException("Error: Failed to write to {$readmeFile}");
    }

    echo "Day {$dayFormatted} generated successfully with name '{$name}'.\n";
}

// Ensure the script is executed, not included
if (php_sapi_name() === "cli" && isset($_SERVER['SCRIPT_FILENAME'])) {
    $scriptFilename = $_SERVER['SCRIPT_FILENAME'] ?? null;

    if ($scriptFilename === null || __FILE__ !== realpath($scriptFilename)) {
        echo "Error: Could not verify script execution context.\n";
        exit(1);
    }

    $day = isset($argv[1]) && is_numeric($argv[1]) ? (int) $argv[1] : null;
    $name = $argv[2] ?? null;

    if ($day === null || $name === null || $name === '') {
        echo "Error: You must provide both the day number and the adventure name.\n";
        echo "Usage: php generateNewDay.php DAY 'Adventure Name'\n";
        exit(1);
    }

    generateNewDay($day, $name);
}
