<?php

/**
 * Solution for Advent of Code Day 01.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-01 11:08:55
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-02 10:40:32
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day01 extends AbstractDay
{
    /**
     * Parses input lines into two sorted columns.
     *
     * @param  string[] $lines
     * @return array{col1: int[], col2: int[]}
     */
    private function parseColumns(array $lines): array
    {
        $col1 = [];
        $col2 = [];
        foreach ($lines as $line) {
            $columns = preg_split('/\s+/', trim($line));
            [$c1, $c2] = array_map('intval', $columns);
            $col1[] = $c1;
            $col2[] = $c2;
        }

        return ['col1' => $col1, 'col2' => $col2];
    }

    /**
     * Calculates the absolute difference sum between two columns.
     *
     * @param  string[] $lines
     * @return int
     */
    public function solvePart1(array $lines): int
    {
        ['col1' => $col1, 'col2' => $col2] = $this->parseColumns($lines);

        // Sort both arrays
        sort($col1);
        sort($col2);

        // Calculate the differences
        return array_sum(
            array_map(
                fn($index) => abs($col1[$index] - $col2[$index]),
                array_keys($col1)
            )
        );
    }

    /**
     * Calculates the similarity score between two columns.
     *
     * @param  string[] $lines
     * @return int
     */
    public function solvePart2(array $lines): int
    {
        ['col1' => $col1, 'col2' => $col2] = $this->parseColumns($lines);

        // Count occurrences in col2
        $col2Counts = array_count_values($col2);

        // Calculate the score
        return array_sum(
            array_map(
                fn($value) => $value * ($col2Counts[$value] ?? 0),
                $col1
            )
        );
    }

    /**
     * Solves the puzzle and returns results for both parts.
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
