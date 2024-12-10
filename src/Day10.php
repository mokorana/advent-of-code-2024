<?php

/**
 * Solution for Advent of Code Day 10.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-10 09:26:59
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-10 15:39:06
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day10 extends AbstractDay
{
    /**
     * Find all trailheads (positions with value 0) in the grid.
     *
     * @param array<string> $grid The grid lines as an array of strings.
     * @return array<int[]> List of [row, column] coordinates of trailheads.
     */
    private function findTrailheads(array $grid): array
    {
        $trailheads = [];

        foreach ($grid as $r => $row) {
            for ($i = 0; $i < strlen($row); $i++) {
                if ($row[$i] == 0) {
                    $trailheads[] = [$r, $i];
                }
            }
        }

        return $trailheads;
    }

    /**
     * Recursively find all valid trails from the given trailhead.
     *
     * @param array<string> $grid The grid lines as an array of strings.
     * @param array<int> $trailhead The starting coordinates [row, column].
     * @param bool $pt2 Whether to enable part 2 rules for trail merging.
     * @return array<string> A list of unique trail identifiers.
     */
    private function getTrails(array $grid, array $trailhead, bool $pt2): array
    {
        [$x, $y] = $trailhead;

        if ($grid[$x][$y] == 9) {
            return ["$x-$y"];
        }

        $directions = [
            [-1, 0], // north
            [0, 1], // east
            [1, 0], // south
            [0, -1] // west
        ];

        $trails = [];

        foreach ($directions as $dir) {
            $xd = $x + $dir[0];
            $yd = $y + $dir[1];

            // Bounds check
            if ($xd < 0 || $xd >= count($grid) || $yd < 0 || $yd >= strlen($grid[$xd])) {
                continue;
            }

            // Validate height progression
            if ((int)$grid[$xd][$yd] - (int)$grid[$x][$y] !== 1) {
                continue;
            }

            $trails = array_merge($trails, $this->getTrails($grid, [$xd, $yd], $pt2));
        }

        // Part 2 rules for merging trails
        return $pt2 ? $trails : array_unique($trails);
    }

    /**
     * Solve part 1 & 2 of the challenge.
     *
     * @param array<string> $grid The grid lines as an array of strings.
     * @param bool $pt2 Whether to enable part 2 rules for trail merging.
     * @return int The total number of valid trails.
     */
    public function solvePart(array $grid, bool $pt2 = false): int
    {
        $trailheads = $this->findTrailheads($grid);

        $trails = 0;
        foreach ($trailheads as $trailhead) {
            $trails += count($this->getTrails($grid, $trailhead, $pt2));
        }

        return $trails;
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
            "Part 1" => $this->solvePart($lines),
            "Part 2" => $this->solvePart($lines, true)
        ];
    }
}
