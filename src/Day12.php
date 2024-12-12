<?php

/**
 * Solution for Advent of Code Day 12.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-12 09:11:35
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-12 16:15:26
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day12 extends AbstractDay
{
    /**
     * Directions for map traversal.
     */
    private const DIRECTIONS = [
        [-1, 0], // NOTH
        [0, 1],  // EAST
        [1, 0],  // SOUTH
        [0, -1], // WEST
    ];

    /**
     * Tracks visited cells.
     */
    public array $visited = [];

    /**
     * Recursively calculates the area and perimeter of a connected region.
     *
     * @param array<int, array<string>> $grid The grid representing the region map.
     * @param int $row The current row index.
     * @param int $col The current column index.
     * @param array<string, array<bool>> $fences Tracks boundaries for each cell in the region.
     * @return array<int> Returns an array containing [area, perimeter].
     */
    private function findRegion(array $grid, int $row, int $col, array &$fences): array
    {
        // Mark the current cell as visited.
        $this->visited["$row-$col"] = true;

        $area = 1;
        $perimeter = 0;

         // Initialize fences for the current cell if not already set.
        if (!isset($fences["$row-$col"])) {
            $fences["$row-$col"] = [false, false, false, false];
        }

        // Traverse all possible directions
        foreach (static::DIRECTIONS as $d => $dir) {
            $rd = $row + $dir[0];
            $cd = $col + $dir[1];

            // Check if the adjacent cell is out of bounds or part of another region.
            if (
                $rd < 0 || $cd < 0 ||
                $rd >= count($grid) || $cd >= count($grid[$row]) ||
                $grid[$rd][$cd] !== $grid[$row][$col]
            ) {
                $perimeter += 1;
                $fences["$row-$col"][$d] = true;
            } elseif (!isset($this->visited["$rd-$cd"])) {
                // Recursively explore the connected region.
                [$a, $p] = $this->findRegion($grid, $rd, $cd, $fences);
                $area += $a;
                $perimeter += $p;
            }
        }

        return [$area, $perimeter];
    }

    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @return int
     */
    public function solvePart1(array $lines): int
    {
        $map = array_map('str_split', $lines);
        $pt1 = 0;

        foreach ($map as $r => $row) {
            foreach (array_keys($row) as $c) {
                // Skip cells that are already visited.
                if (isset($this->visited["$r-$c"])) {
                    continue;
                }

                $fences = [];

                // Calculate area and perimeter for the current region.
                [$area, $perimeter] = $this->findRegion($map, $r, $c, $fences);
                $pt1 += ($area * $perimeter);
            }
        }

        return $pt1;
    }

    /**
     * Solve part 2 of the challenge.
     *
     * @psalm-suppress UnusedVariable
     * @param array<string> $lines The grid lines.
     * @return int
     */
    public function solvePart2(array $lines): int
    {
        $map = array_map('str_split', $lines);
        $pt2 = 0;
        $this->visited = [];

        foreach ($map as $r => $row) {
            foreach (array_keys($row) as $c) {
                // Skip cells that are already visited.
                if (isset($this->visited["$r-$c"])) {
                    continue;
                }

                $fences = [];

                 // Calculate area and perimeter for the current region.
                [$area, $perimeter] = $this->findRegion($map, $r, $c, $fences);

                // Count all sides (fences) within the region.
                $sides = 0;
                for ($i = 0; $i < count($map); $i++) {
                    // Count NORTH side
                    for ($j = 0; $j < count($map[0]); $j++) {
                        if (isset($fences["$i-$j"]) && $fences["$i-$j"][0]) {
                            $sides += 1;
                            while (isset($fences["$i-" . ($j + 1)]) && $fences["$i-" . ($j + 1)][0]) {
                                $j++;
                            }
                        }
                    }

                    // Count SOUTH side>
                    for ($j = 0; $j < count($map[0]); $j++) {
                        if (isset($fences["$i-$j"]) && $fences["$i-$j"][2]) {
                            $sides += 1;
                            while (isset($fences["$i-" . ($j + 1)]) && $fences["$i-" . ($j + 1)][2]) {
                                $j++;
                            }
                        }
                    }
                }

                for ($i = 0; $i < count($map); $i++) {
                    // Count EAST side
                    for ($j = 0; $j < count($map); $j++) {
                        if (isset($fences["$j-$i"]) && $fences["$j-$i"][1]) {
                            $sides += 1;
                            while (isset($fences["$j-$i"]) && $fences["$j-$i"][1]) {
                                $j++;
                            }
                        }
                    }

                    // Count WEST side
                    for ($j = 0; $j < count($map); $j++) {
                        if (isset($fences["$j-$i"]) && $fences["$j-$i"][3]) {
                            $sides += 1;
                            while (isset($fences["$j-$i"]) && $fences["$j-$i"][3]) {
                                $j++;
                            }
                        }
                    }
                }

                $pt2 += $sides * $area;
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
        $lines = explode("\n", $this->getInputString());
        return [
            "Part 1" => $this->solvePart1($lines),
            "Part 2" => $this->solvePart2($lines)
        ];
    }
}
