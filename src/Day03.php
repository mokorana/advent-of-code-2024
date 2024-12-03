<?php

/**
 * Unit tests for the Advent of Code Day {dayFormatted} solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-03 08:25:26
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-03 11:25:02
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day03 extends AbstractDay
{
    /**
     * Matches the pattern for numbers in the format "x,y)" and returns their product.
     *
     * @param string $line A single line of input to be matched.
     * @return int The product of the two numbers if the pattern matches, or 0 otherwise.
     */
    private function matchPattern(string $line): int
    {
        $pattern = '/^\d{1,3},\d{1,3}\)/'; // Matches "x,y)" where x and y are 1-3 digits.

        // Check if the pattern matches
        if (preg_match($pattern, $line, $matches)) {
            // Remove the trailing ")" and split into two numbers
            $values = explode(",", rtrim($matches[0], ')'));

            // Return the product of the two numbers
            return (int)$values[0] * (int)$values[1];
        }

        return 0;
    }

    /**
     * Solves Part 1 by processing each line and summing up the products.
     *
     * @param array $lines Input lines split by "mul("
     * @return int The total sum of all valid products.
     */
    public function solvePart1(array $lines): int
    {
        $sum = 0;

        foreach ($lines as $line) {
            $sum += $this->matchPattern($line);
        }

        return $sum;
    }

    /**
     * Solves Part 2 by handling lines split by "don't()" and then "mul(".
     *
     * @param array $lines Input lines split by "do()"
     * @return int The total sum of all valid products in enabled parts.
     */
    public function solvePart2(array $lines): int
    {
        $sum = 0;

        foreach ($lines as $line) {
            // Split line by "don't()" to exclude disabled parts
            $enabledPart = preg_split("/don't\\(\\)/", $line);

            // Split the enabled part further by "mul("
            $enabledLines = preg_split('/mul\\(/', $enabledPart[0]);

            // Process each line and sum the products
            foreach ($enabledLines as $enabledLine) {
                $sum += $this->matchPattern($enabledLine);
            }
        }

        return $sum;
    }

    /**
     * Main solution function to handle input and return results for both parts.
     *
     * @return array<string, int>
     */
    public function solve(): array
    {
        // Split input for Part 1 by "mul("
        $linesPart1 = preg_split('/mul\\(/', $this->getInputString());

        // Split input for Part 2 by "do()"
        $linesPart2 = preg_split('/do\(\)/', $this->getInputString());

        return [
            "Part 1" => $this->solvePart1($linesPart1),
            "Part 2" => $this->solvePart2($linesPart2)
        ];
    }
}
