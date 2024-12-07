<?php

/**
 * Solution for Advent of Code Day 07.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-07 08:03:54
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-07 12:21:49
 *
 * @package Aoc
 */

namespace Aoc;

use PhpParser\Node\Stmt\Foreach_;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day07 extends AbstractDay
{
    /**
     * Parses input lines into structured data.
     *
     * @param array<string> $data The input data lines to parse.
     * @return array<array{int, array<int>}> A list of [expected, numbers] pairs.
     */
    private function parseData(array $data): array
    {
        $parsedData = array_map(function ($line) {
            [$expected, $numbers] = explode(": ", $line);
            $numbers = array_map(function ($n) {
                return intval($n);
            }, explode(" ", $numbers));

            return [intval($expected), array_reverse($numbers)];
        }, $data);

        return $parsedData;
    }

    /**
     * Recursively evaluates whether the expected result can be achieved.
     *
     * @param int $expected The target result to achieve.
     * @param int $current The current accumulated value being evaluated.
     * @param array<int> $numbers The remaining numbers to process.
     * @param bool $concat Whether to allow concatenation of numbers as a valid operation.
     * @return bool True if the expected result can be achieved; false otherwise.
     */
    private function evaluate(int $expected, int $current, array $numbers, bool $concat = false): bool
    {
        if ($current > $expected) {
            return false;
        }

        if (count($numbers) === 0) {
            return $current === $expected;
        }

        $next = array_pop($numbers);
        return $this->evaluate($expected, $current * $next, $numbers, $concat)
            || $this->evaluate($expected, $current + $next, $numbers, $concat)
            || ($concat && $this->evaluate($expected, intval("$current$next"), $numbers, $concat));
    }

    /**
     * Solve part 1 & 2 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @param bool $concat Whether to allow concatenation of numbers as a valid operation.
     * @return int
     */
    public function solvePart(array $lines, bool $concat): int
    {
        $sum = 0;
        $data = $this->parseData($lines);

        foreach ($data as [$expected, $numbers]) {
            $left = array_pop($numbers);
            $sum += $this->evaluate($expected, $left, $numbers, $concat) ? $expected : 0;
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
        $lines = explode("\n", $this->getInputString());
        return [
        "Part 1" => $this->solvePart($lines, false),
        "Part 2" => $this->solvePart($lines, true)
        ];
    }
}
