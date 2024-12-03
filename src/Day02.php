<?php

/**
 * Solution for Advent of Code Day 02.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-02 10:32:11
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-03 11:19:39
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day02 extends AbstractDay
{
    /**
     * Parses input lines into arrays of integers.
     *
     * @param  string[] $lines
     * @return int[][]
     */
    private function parseLines(array $lines): array
    {
        return array_map(
            fn($line) => array_map('intval', preg_split('/\s+/', trim($line))),
            $lines
        );
    }

    /**
     * Determines if a line is "safe."
     *
     * A line is considered safe if:
     * - It is sorted (ascending or descending).
     * - The absolute difference between consecutive numbers is <= 3.
     * - No duplicate values exist.
     *
     * @param  int[] $numbers
     * @return bool
     */
    private function isSafeLine(array $numbers): bool
    {
        // Check if sorted in ascending or descending order
        $sorted = $numbers;
        $reverseSorted = $numbers;
        sort($sorted);
        rsort($reverseSorted);

        if ($numbers !== $sorted && $numbers !== $reverseSorted) {
            return false;
        }

        // Check consecutive differences and duplicates
        for ($i = 0; $i < count($numbers) - 1; $i++) {
            $diff = abs($numbers[$i] - $numbers[$i + 1]);
            if ($diff > 3 || $numbers[$i] === $numbers[$i + 1]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determines the number of "safe" lines from the given input.
     *
     * @param  string[] $lines
     * @return int
     */
    public function solvePart1(array $lines): int
    {

        $parsedLines = $this->parseLines($lines);
        $safeCount = 0;

        // Process each parsed line
        foreach ($parsedLines as $numbers) {
            if ($this->isSafeLine($numbers)) {
                $safeCount++;
            }
        }

        return $safeCount;
    }

    /**
     * Calculates the count of "safe" lines, considering partial safety.
     *
     * @param  string[] $lines
     * @return int
     */
    public function solvePart2(array $lines): int
    {

        $parsedLines = $this->parseLines($lines);
        $safeCountNew = 0;

        // Process each parsed line
        foreach ($parsedLines as $numbers) {
            if ($this->isSafeLine($numbers)) {
                $safeCountNew++;
            } else {
                // Check if removing one number makes the line safe
                foreach (array_keys($numbers) as $index) {
                    $testArray = $numbers;
                    unset($testArray[$index]);
                    $testArray = array_values($testArray); // Reindex array

                    if ($this->isSafeLine($testArray)) {
                        $safeCountNew++;
                        break; // Stop checking after finding one safe combination
                    }
                }
            }
        }

        return $safeCountNew;
    }

    /**
     * Solves the puzzle and returns parsedLines for both parts.
     *
     * @return array<string, int>
     */
    public function solve(): array
    {
        $lines = explode("\n", $this->getInputString());


        return [
            "Part 1" => $this->solvePart1($lines),
            "Part 2" => $this->solvePart2($lines)
        ];
    }
}
