<?php

/**
 * Solution for Advent of Code Day 19.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-19 09:15:39
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-19 11:31:06
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day19 extends AbstractDay
{
    /**
     * Try to match the design using patterns.
     *
     * @param string $design
     * @param array<string> $patterns
     * @return int
     */
    private function try(string $design, array $patterns): int
    {
        static $cache = [];
        if ($design === '') {
            return 1;
        }
        if (isset($cache[$design])) {
            return $cache[$design];
        }

        $p = 0;
        foreach ($patterns as $pattern) {
            if (str_starts_with($design, $pattern)) {
                $p += $this->try(substr($design, strlen($pattern)), $patterns);
            }
        }

        $cache[$design] = $p;
        return $p;
    }

    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $parts The grid lines.
     * @return int
     */
    public function solvePart1(array $parts): int
    {
        // Get patterns and designs
        $patterns = explode(', ', $parts[0]);
        $designs = explode("\n", $parts[1]);

        $pt1 = 0;
        // Filter designs
        foreach ($designs as $design) {
            if ($this->try($design, $patterns)) {
                $pt1++;
            }
        }

        return $pt1;
    }

    /**
     * Solve part 2 of the challenge.
     *
     * @param array<string> $parts The grid lines.
     * @return int
     */
    public function solvePart2(array $parts): int
    {
        // Get patterns and designs
        $patterns = explode(', ', $parts[0]);
        $designs = explode("\n", $parts[1]);

        $pt2 = 0;
        // Filter designs
        foreach ($designs as $design) {
            if ($p = $this->try($design, $patterns)) {
                $pt2 += $p;
            }
        }

        return $pt2;
    }

    /**
     * Main solution function to handle input and return results for both parts.
     *
     * @return array<string, int>
     */
    public function solve(): array
    {
        $parts = explode("\n\n", $this->getInputString());
        return [
            "Part 1" => $this->solvePart1($parts),
            "Part 2" => $this->solvePart2($parts)
        ];
    }
}
