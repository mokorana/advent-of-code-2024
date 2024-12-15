<?php

/**
 * Solution for Advent of Code Day 14.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-14 07:06:50
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-15 18:28:41
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day14 extends AbstractDay
{
    private const WIDTH = 101;
    private const HEIGHT = 103;

    /**
     * Parse the input data into an array of robot properties.
     *
     * @param array<string> $lines The input lines.
     * @return array<array<string, int>> Parsed robot data.
     */
    private function parseRobots(array $lines): array
    {
        $robots = [];
        foreach ($lines as $line) {
            if (preg_match_all('/(-?\d+)/', $line, $matches) !== false) {
                $robots[] = [
                    'x' => (int)$matches[1][0],
                    'y' => (int)$matches[1][1],
                    'vx' => (int)$matches[1][2],
                    'vy' => (int)$matches[1][3],
                ];
            }
        }
        return $robots;
    }

    /**
     * Calculate the quadrant of a robot after a given number of seconds.
     *
     * @param array<string, int> $robot Robot properties.
     * @param int $seconds Time in seconds.
     * @return int The quadrant number (1, 2, 3, 4) or 0 for middle.
     */
    private function getQuadrant(array $robot, int $seconds): int
    {
        $x = ($robot['x'] + $seconds * $robot['vx']) % self::WIDTH;
        if ($x < 0) {
            $x += self::WIDTH;
        }

        $y = ($robot['y'] + $seconds * $robot['vy']) % self::HEIGHT;
        if ($y < 0) {
            $y += self::HEIGHT;
        }

        $yMid = (int)(self::HEIGHT / 2);
        $xMid = (int)(self::WIDTH / 2);

        if ($x === $xMid || $y === $yMid) {
            return 0;
        }

        if ($x < $xMid) {
            return $y < $yMid ? 1 : 3;
        }

        return $y < $yMid ? 2 : 4;
    }

    /**
     * Move a robot for a given number of seconds.
     *
     * @param array<string, int> $robot Robot properties.
     * @param int $seconds Time in seconds.
     * @return void
     */
    private function moveRobot(array &$robot, int $seconds): void
    {
        $robot['x'] = ($robot['x'] + $seconds * $robot['vx']) % self::WIDTH;
        if ($robot['x'] < 0) {
            $robot['x'] += self::WIDTH;
        }

        $robot['y'] = ($robot['y'] + $seconds * $robot['vy']) % self::HEIGHT;
        if ($robot['y'] < 0) {
            $robot['y'] += self::HEIGHT;
        }
    }


    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $lines The input lines.
     * @return int
     */
    public function solvePart1(array $lines): int
    {
        $robots = $this->parseRobots($lines);
        $quadrants = [0, 0, 0, 0, 0];

        foreach ($robots as $robot) {
            $quadrant = $this->getQuadrant($robot, 100);
            $quadrants[$quadrant]++;
        }

        /** @psalm-suppress PossiblyUndefinedArrayOffset */
        return $quadrants[1] * $quadrants[2] * $quadrants[3] * $quadrants[4];
    }

    /**
     * Solve part 2 of the challenge.
     *
     * @param array<string> $lines The input lines.
     * @return int
     */
    public function solvePart2(array $lines): int
    {
        $robots = $this->parseRobots($lines);
        $emptyGrid = array_fill(0, self::HEIGHT, str_repeat('.', self::WIDTH));
        $needle = str_repeat('O', 7);
        $seconds = 0;

        while (true) {
            $grid = $emptyGrid;

            foreach ($robots as &$robot) {
                $this->moveRobot($robot, 1);
                $grid[$robot['y']][$robot['x']] = 'O';
            }

            foreach ($grid as $row) {
                /** @psalm-suppress PossiblyInvalidCast, PossiblyInvalidArgument */
                if (strpos($row, $needle) !== false) {
                    return $seconds + 1;
                }
            }

            $seconds++;
        }
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
