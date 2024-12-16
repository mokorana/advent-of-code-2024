<?php

/**
 * Solution for Advent of Code Day 16.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-16 09:31:53
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-16 14:32:26
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day16 extends AbstractDay
{
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
     * Sorts the queue by distance.
     *
     * @param array $queue Reference to the queue array.
     */
    private function sortQueue(array &$queue): void
    {
        usort($queue, static function (array $a, array $b): int {
            return $a[0] <=> $b[0];
        });
    }

    /**
     * Finds the start and end positions in the grid.
     *
     * @param array<array<string>> $grid The 2D grid array.
     * @return array<string, array<string, int>|null> Start and end positions.
     */
    private function findPositions(array $grid): array
    {
        $start = $end = null;

        foreach ($grid as $rowIndex => $row) {
            foreach ($row as $colIndex => $cell) {
                if ($cell === 'S') {
                    $start = ['row' => $rowIndex, 'col' => $colIndex];
                } elseif ($cell === 'E') {
                    $end = ['row' => $rowIndex, 'col' => $colIndex];
                }

                // Exit early if both positions are found
                if ($start !== null && $end !== null) {
                    return ['start' => $start, 'end' => $end];
                }
            }
        }

        return ['start' => $start, 'end' => $end];
    }

    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @return int
     */
    public function solvePart1(array $lines): int
    {
        $grid = array_map('str_split', $lines);

        $positions = $this->findPositions($grid);
        $start = $positions['start'];
        $end = $positions['end'];

        if ($start === null || $end === null) {
            return 0;
        }

        // Forward loop
        $queue = [[0, $start['row'], $start['col'], 1]];
        $seen = [];
        $pt1 = 0;

        while (!empty($queue)) {
            $this->sortQueue($queue);
            /** @psalm-suppress PossiblyNullArrayAccess, InvalidArrayOffset */
            [$d, $r, $c, $dir] = array_shift($queue) ??  [0, 0, 0, 0];
            // Skip already visited positions
            if (isset($seen["$r-$c-$dir"])) {
                continue;
            }

            $seen["$r-$c-$dir"] = $d;

            // Check if the end is reached
            /** @psalm-suppress PossiblyNullArrayAccess */
            if ($r === $end['row'] && $c === $end['col']) {
                $pt1 = $d;
                break;
            }

            // Move in the current direction
            /** @psalm-suppress PossiblyNullArrayOffset */
            [$dr, $dc] = self::DIRS[$dir];
            $rr = $r + $dr;
            $cc = $c + $dc;

            // Avoid walls
            if ($grid[$rr][$cc] !== '#') {
                $queue[] = [$d + 1, $rr, $cc, $dir];
            }

            // Add options to change directions
            $queue[] = [$d + 1000, $r, $c, ($dir + 1) % 4];
            $queue[] = [$d + 1000, $r, $c, ($dir + 3) % 4];
        }

        return $pt1;
    }

    /**
     * Solve part 2 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @return int
     */
    public function solvePart2(array $lines): int
    {
        $grid = array_map('str_split', $lines);

        $positions = $this->findPositions($grid);
        $start = $positions['start'];
        $end = $positions['end'];

        if ($start === null || $end === null) {
            return 0; // Handle case where start or end is missing
        }

        $queue = [];
        $seen = [];
        $pt1 = 0;

        // Add initial position
        /** @psalm-suppress PossiblyNullArrayAccess */
        $queue[] = [0, $start['row'], $start['col'], 1];

        while (!empty($queue)) {
            $this->sortQueue($queue);
            /** @psalm-suppress PossiblyNullArrayAccess, InvalidArrayOffset */
            [$d, $r, $c, $dir] = array_shift($queue) ??  [0, 0, 0, 0];

            // Skip visited states
            if (isset($seen["$r-$c-$dir"])) {
                continue;
            }
            $seen["$r-$c-$dir"] = $d;

            // Check if the end is reached
            /** @psalm-suppress PossiblyNullArrayAccess */
            if ($r === $end['row'] && $c === $end['col']) {
                $pt1 = $d;
                break;
            }

            // Move in the current direction
            /** @psalm-suppress PossiblyNullArrayOffset */
            [$dr, $dc] = self::DIRS[$dir];
            $rr = $r + $dr;
            $cc = $c + $dc;

            if ($grid[$rr][$cc] !== '#') {
                $queue[] = [$d + 1, $rr, $cc, $dir];
            }

            $queue[] = [$d + 1000, $r, $c, ($dir + 1) % 4];
            $queue[] = [$d + 1000, $r, $c, ($dir + 3) % 4];
        }

        // Backward loop
        $queue = [];
        $seen2 = [];

        // Add initial position
        /** @psalm-suppress PossiblyNullArrayAccess */
        $queue[] = [0, $end['row'], $end['col'], 0];
        $queue[] = [0, $end['row'], $end['col'], 1];
        $queue[] = [0, $end['row'], $end['col'], 2];
        $queue[] = [0, $end['row'], $end['col'], 3];

        while (!empty($queue)) {
            $this->sortQueue($queue);
            /** @psalm-suppress PossiblyNullArrayAccess, InvalidArrayOffset */
            [$d, $r, $c, $dir] = array_shift($queue) ??  [0, 0, 0, 0];

            // Skip visited states
            if (isset($seen2["$r-$c-$dir"])) {
                continue;
            }

            $seen2["$r-$c-$dir"] = $d;

            // Check if the end is reached
            /** @psalm-suppress PossiblyNullArrayAccess */
            if ($r === $start['row'] && $c === $start['col']) {
                break;
            }

            // Move in the opposite direction
            /** @psalm-suppress PossiblyNullArrayOffset */
            [$dr, $dc] = self::DIRS[($dir + 2) % 4];
            $rr = $r + $dr;
            $cc = $c + $dc;

            if ($grid[$rr][$cc] !== '#') {
                $queue[] = [$d + 1, $rr, $cc, $dir];
            }

            $queue[] = [$d + 1000, $r, $c, ($dir + 1) % 4];
            $queue[] = [$d + 1000, $r, $c, ($dir + 3) % 4];
        }

        // Identify optimal paths
        $pt2 = [];
        foreach ($grid as $r => $row) {
            foreach (array_keys($row) as $c) {
                for ($dir = 0; $dir < 4; $dir++) {
                    $key = "$r-$c-$dir";
                    /** @psalm-suppress RedundantCondition */
                    if (isset($seen[$key], $seen2[$key]) && $seen[$key] !== null && $seen2[$key] !== null) {
                        if ($seen[$key] + $seen2[$key] === $pt1) {
                            $pt2["$r-$c"] = true;
                        }
                    }
                }
            }
        }

        return count($pt2);
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
