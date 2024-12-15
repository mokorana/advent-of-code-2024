<?php

/**
 * Solution for Advent of Code Day 15.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-15 11:11:26
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-15 19:02:38
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day15 extends AbstractDay
{
    /**
     * Movement directions represented as [row, column].
     */
    private const DIRECTIONS = [
        '^' => [-1, 0], // NORTH
        '>' => [0, 1],  // EAST
        'v' => [1, 0],  // SOUTH
        '<' => [0, -1]  // WEST
    ];

    /**
     * Moves a box in the specified direction if possible.
     *
     * @param array $grid The grid representation.
     * @param int $x The current row of the box.
     * @param int $y The current column of the box.
     * @param string $m The movement direction.
     * @return bool True if the box was moved, false otherwise.
     */
    private function moveBoxes(array &$grid, int $x, int $y, string $m): bool
    {
        $oX = $x;
        $oY = $y;
        while (true) {
            $bX = $x + static::DIRECTIONS[$m][0];
            $bY = $y + static::DIRECTIONS[$m][1];

            if ($grid[$bX][$bY] == '.') {
                $grid[$bX][$bY] = 'O';
                $grid[$oX][$oY] = '.';

                return true;
            }

            if ($grid[$bX][$bY] == '#') {
                return false;
            } else {
                $x = $bX;
                $y = $bY;
            }
        }
    }

    /**
     * Pushes boxes in the specified direction if possible.
     *
     * @param array $map The grid representation with doubled columns.
     * @param int $robotR Robot's current row.
     * @param int $robotC Robot's current column.
     * @param int $dr Row direction.
     * @param int $dc Column direction.
     * @return bool True if the boxes were pushed, false otherwise.
     */
    private function pushBoxes(array &$map, int $robotR, int $robotC, int $dr, int $dc): bool
    {
        $queue = [[$robotR, $robotC]];
        $seen = [];
        $boxes = [];

        // Locate connected box parts
        while (!empty($queue)) {
            [$r, $c] = array_shift($queue);
            if (isset($seen["$r-$c"])) {
                continue;
            }
            $seen["$r-$c"] = true;

            if ($map[$r][$c] === '[' || $map[$r][$c] === ']') {
                $boxes[] = [$r, $c];

                if ($map[$r][$c] === '[' && isset($map[$r][$c + 1]) && $map[$r][$c + 1] === ']') {
                    $queue[] = [$r, $c + 1];
                }

                if ($map[$r][$c] === ']' && isset($map[$r][$c - 1]) && $map[$r][$c - 1] === '[') {
                    $queue[] = [$r, $c - 1];
                }
            }

            if ($map[$r + $dr][$c + $dc] === '[' || $map[$r + $dr][$c + $dc] === ']') {
                $queue[] = [$r + $dr, $c + $dc];
            }
        }

        // Validate move
        foreach ($boxes as [$r, $c]) {
            $nextR = $r + $dr;
            $nextC = $c + $dc;

            if (!isset($map[$nextR][$nextC]) || $map[$nextR][$nextC] == '#') {
                return false; // Cannot move the box
            }
        }

        // Move boxes
        foreach (array_reverse($boxes) as [$r, $c]) {
            $nextR = $r + $dr;
            $nextC = $c + $dc;

            $map[$nextR][$nextC] = $map[$r][$c];
            $map[$r][$c] = '.';
        }

        return true;
    }


    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $parts The grid lines.
     * @return int
     */
    public function solvePart1(array $parts): int
    {
        $grid = explode("\n", $parts[0]);
        $movements = str_replace("\n", "", $parts[1]);

        // Find robot
        $robot = [];
        foreach ($grid as $r => $row) {
            for ($c = 0; $c < strlen($row); $c++) {
                if ($row[$c] == '@') {
                    $robot = [$r, $c];
                }
            }
        }

        if (count($robot) !== 2) {
            throw new \RuntimeException('Robot position is not defined.');
        }

        // Move Robot
        for ($m = 0; $m < strlen($movements); $m++) {
            $rX = $robot[0] + static::DIRECTIONS[$movements[$m]][0];
            $rY = $robot[1] + static::DIRECTIONS[$movements[$m]][1];

            if ($grid[$rX][$rY] == 'O' && !$this->moveBoxes($grid, $rX, $rY, $movements[$m])) {
                continue;
            }

            if ($grid[$rX][$rY] !== '#') {
                $grid[$robot[0]][$robot[1]] = '.';
                $grid[$rX][$rY] = '@';
                $robot = [$rX, $rY];
            }
        }

        // Get GPS coordinates
        $pt1 = 0;
        foreach ($grid as $r => $row) {
            if (!is_string($row)) {
                throw new \UnexpectedValueException('Each row must be a string.');
            }

            for ($c = 0; $c < strlen($row); $c++) {
                if ($row[$c] == 'O') {
                    $pt1 += 100 * (int)$r + $c;
                }
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
        $grid = explode("\n", $parts[0]);
        $movements = str_replace("\n", "", $parts[1]);

        // Double map
        $map = [];
        foreach ($grid as $r => $row) {
            for ($c = 0; $c < strlen($row); $c++) {
                if ($row[$c] === 'O') {
                    $map[$r][$c * 2] = '[';
                    $map[$r][$c * 2 + 1] = ']';
                } elseif ($row[$c] === '@') {
                    $map[$r][$c * 2] = '@';
                    $map[$r][$c * 2 + 1] = '.';
                } else {
                    $map[$r][$c * 2] = $row[$c];
                    $map[$r][$c * 2 + 1] = $row[$c];
                }
            }
        }

        // Find robot
        $robot = [];
        foreach ($map as $r => $row) {
            for ($c = 0; $c < count($row); $c++) {
                if ($row[$c] == '@') {
                    $robot = [$r, $c];
                    break 2;
                }
            }
        }

        // Validate $robot
        if (count($robot) !== 2) {
            throw new \RuntimeException('Robot position is not defined.');
        }

        // Move Robot
        foreach (str_split($movements) as $m) {
            [$dr, $dc] = self::DIRECTIONS[$m];
            $nextR = $robot[0] + $dr;
            $nextC = $robot[1] + $dc;

            if (
                ($map[$nextR][$nextC] === '[' || $map[$nextR][$nextC] === ']') &&
                !$this->pushBoxes($map, $nextR, $nextC, $dr, $dc)
            ) {
                continue;
            }

            if ($map[$nextR][$nextC] !== '#') {
                $map[$robot[0]][$robot[1]] = '.';
                $map[$nextR][$nextC] = '@';
                $robot = [$nextR, $nextC];
            }
        }

        // Get GPS coordinates
        $pt2 = 0;
        foreach ($map as $r => $row) {
            for ($c = 0; $c < count($row); $c++) {
                if ($row[$c] === '[') {
                    $pt2 += 100 * (int) $r + $c;
                }
            }
        }

        return (int)$pt2;
    }

    /**
     * Main solution function to handle input and return results for both parts.
     *
     * @return array<string, int>
     */
    public function solve(): array
    {
        $lines = explode("\n\n", $this->getInputString());
        return [
        "Part 1" => $this->solvePart1($lines),
        "Part 2" => $this->solvePart2($lines)
        ];
    }
}
