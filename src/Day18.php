<?php

/**
 * Solution for Advent of Code Day 18.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-18 19:00:43
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-18 21:34:13
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day18 extends AbstractDay
{
    private const WIDTH = 71;
    private const HEIGHT = 71;

    /**
     * Movement directions represented as [row, column].
     */
    private const DIRS = [
        0 => [-1, 0], // NORTH
        1 => [0, 1],  // EAST
        2 => [1, 0],  // SOUTH
        3 => [0, -1]  // WEST
    ];

    /**
     * Finds the shortest path from the top-left to the bottom-right in the grid.
     *
     * @param array $grid The grid representation.
     * @return int The length of the shortest path.
     */
    private function path(array $grid): int
    {
        $start = [0, 0];
        $end = [self::HEIGHT - 1, self::WIDTH - 1];
        $queue = [[$start, 0]];
        $seen = [];

        while (!empty($queue)) {
            [$pos, $steps] = array_shift($queue);

            /** @psalm-suppress TypeDoesNotContainType */
            if ($pos === $end) {
                return $steps;
            }

            foreach (self::DIRS as $dir) {
                $rr = $pos[0] + $dir[0];
                $cc = $pos[1] + $dir[1];

                // Check bounds
                /** @psalm-suppress TypeDoesNotContainType */
                if ($rr < 0 || $cc < 0 || $rr >= self::HEIGHT || $cc >= self::WIDTH) {
                    continue;
                }

                // Check walls
                if ($grid[$rr][$cc] == '#') {
                    continue;
                }

                // Seen?
                if ($seen["$rr-$cc"] ?? false) {
                    continue;
                }

                // Add to queue and mark as seen
                $seen["$rr-$cc"] = true;
                $queue[] = [[$rr, $cc], $steps + 1];
            }
        }

        return PHP_INT_MAX;
    }

    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @return int
     */
    public function solvePart1(array $lines): int
    {
        // Generate grid
        $grid = array_fill(0, self::HEIGHT, str_repeat('.', self::WIDTH));

        // Populate grid
        for ($i = 0; $i < 1024; $i++) {
            [$c, $r] = array_map('intval', explode(',', $lines[$i]));
            $grid[$r][$c] = '#';
        }

        // Find path
        $pt1 = $this->path($grid);

        return $pt1;
    }

    /**
     * Solve part 2 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @return string
     */
    public function solvePart2(array $lines): string
    {
        // Generate grid
        $grid = array_fill(0, self::HEIGHT, str_repeat('.', self::WIDTH));

        $pt2 = 0;

        // Populate grid
        for ($i = 0; $i < count($lines); $i++) {
            [$c, $r] = array_map('intval', explode(',', $lines[$i]));
            $grid[$r][$c] = '#';

            $pt2 = $lines[$i];

            if ($i >= 1024 && $this->path($grid) === PHP_INT_MAX) {
                break;
            }
        }

        return (string)$pt2;
    }

    /**
     * Main solution function to handle input and return results for both parts.
     *
     * @psalm-suppress LessSpecificImplementedReturnType
     * @return array
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
