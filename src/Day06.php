<?php

/**
 * Solution for Advent of Code Day 06.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-06 10:32:26
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-06 15:50:05
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day06 extends AbstractDay
{
    // Map symbols to numeric directions for the guard's movement.
    private const DIRECTION_MAP = [
        '^' => 0,
        '>' => 1,
        'v' => 2,
        '<' => 3
    ];

    // Direction offsets for movement in the grid.
    private const DIRECTION_OFFSETS = [
        [-1, 0], // Up
        [0, 1],  // Right
        [1, 0],  // Down
        [0, -1]  // Left
    ];

    /**
     * Parse the input lines into a grid representation.
     *
     * @param array<string> $lines The input lines representing the grid.
     * @return array<array<string>> A 2D array representing the grid.
     */
    private function parseGrid(array $lines): array
    {
        $gridList = [];
        foreach ($lines as $line) {
            $trimmedLine = trim($line);
            $gridList[] = mb_str_split($trimmedLine);
        }

        return $gridList;
    }

    /**
     * Find the guard's starting position and direction in the grid.
     *
     * @param array<array<string>> $grid The 2D grid.
     * @return array{array<int>, int} An array containing: guard's starting position  direction.
     */
    private function findGuard(array $grid): array
    {
        foreach ($grid as $r => $row) {
            foreach ($row as $c => $cell) {
                if (array_key_exists($cell, self::DIRECTION_MAP)) {
                    $guardPos = [$r, $c];
                    $guardDir = self::DIRECTION_MAP[$cell];
                    $grid[$r][$c] = '.'; // Clear the starting position

                    return [$guardPos, $guardDir];
                }
            }
        }
        throw new \Exception("Guard not found in the grid.");
    }

    /**
     * Identify all possible positions that could obstruct the guard's path.
     *
     * @param array<array<string>> $grid The 2D grid.
     * @param array<int> $guardPos The guard's starting position as [row, column].
     * @return array<array<int>> A list of possible obstruction positions [row, column].
     */
    private function getPossibleObstructions(array $grid, array $guardPos): array
    {
        $possible = [];
        foreach ($grid as $r => $row) {
            foreach ($row as $c => $cell) {
                if (!(($r === $guardPos[0]) && ($c === $guardPos[1])) && $cell === '.') {
                    $possible[] = [$r, $c];
                }
            }
        }
        return $possible;
    }

    /**
     * Simulate the guard's movement and determine if it enters a loop.
     *
     * @param array<array<string>> $grid The 2D grid.
     * @param array<int> $startPos The guard's starting position as [row, column].
     * @param int $startDir The guard's initial direction (0 = Up, 1 = Right, 2 = Down, 3 = Left).
     * @return bool True if a loop is detected, false if the guard exits the grid.
     */
    private function simulateMovement(array $grid, array $startPos, int $startDir): bool
    {
        $visitedStates = [];

        $r = $startPos[0];
        $c = $startPos[1];
        $direction = $startDir;

        while (true) {
            // Create a unique key for the current state
            $stateKey = serialize([$r, $c, $direction]); // Using "$r, $c, $direction" is less performant

            // Check for loops
            if (isset($visitedStates[$stateKey])) {
                return true; // Loop detected
            }

            // Mark the state as visited
            $visitedStates[$stateKey] = true;

            // Calculate the next position based on the direction
            $dr = self::DIRECTION_OFFSETS[$direction][0];
            $dc = self::DIRECTION_OFFSETS[$direction][1];
            $newR = $r + $dr;
            $newC = $c + $dc;

            // Check boundaries
            if ($newR < 0 || $newR >= count($grid) || $newC < 0 || $newC >= count($grid[0])) {
                return false; // Guard exits the grid
            }

            // Check for obstacles
            if ($grid[$newR][$newC] === '#') {
                // Turn right if obstacle ahead
                $direction = ($direction + 1) % 4;
            } else {
                // Move forward
                $r = $newR;
                $c = $newC;
            }
        }
    }

    /**
     * Solve part 1 of the challenge. Count the number of distinct positions
     *
     * @param array<string> $lines The grid lines.
     * @return int
     */
    public function solvePart1(array $lines): int
    {
        // Parse the grid
        $grid = $this->parseGrid($lines);

        // Find the guard's starting position and direction
        [$guardPos, $guardDir] = $this->findGuard($grid);

        // Initialize visited positions set
        $visitedPositions = [];
        $visitedPositions["$guardPos[0], $guardPos[1]"] = true;

        // Simulate the guard's movement
        while (true) {
            $dr = self::DIRECTION_OFFSETS[$guardDir][0];
            $dc = self::DIRECTION_OFFSETS[$guardDir][1];
            $newR = $guardPos[0] + $dr;
            $newC = $guardPos[1] + $dc;

            // Check boundaries
            if ($newR < 0 || $newR >= count($grid) || $newC < 0 || $newC >= count($grid[0])) {
                break; // Guard exits the mapped area
            }

            if ($grid[$newR][$newC] === '#') {
                // Turn right if obstacle ahead
                $guardDir = ($guardDir + 1) % 4;
            } else {
                // Move forward
                $guardPos = [$newR, $newC];
                $visitedPositions["$guardPos[0], $guardPos[1]"] = true;
            }
        }

        // Number of distinct positions visited
        return count($visitedPositions);
    }

    /**
     * Solve part 2 of the challenge. Count obstruction positions that cause the guard to loop indefinitely.
     *
     * @param array<string> $lines The grid lines.
     * @return int
     */
    public function solvePart2(array $lines): int
    {
        // Parse the grid
        $grid = $this->parseGrid($lines);

        // Find the guard's starting position and direction
        [$guardPos, $guardDir] = $this->findGuard($grid);

        $possibleObstructions = $this->getPossibleObstructions($grid, $guardPos);

        // Initialize loop counter
        $loopCount = 0;

        foreach ($possibleObstructions as $obstruction) {
            $grid[$obstruction[0]][$obstruction[1]] = '#'; // Place obstruction

            if ($this->simulateMovement($grid, $guardPos, $guardDir)) {
                $loopCount++; // Found a position that causes a loop
            }

            $grid[$obstruction[0]][$obstruction[1]] = '.'; // Remove obstruction
        }

        return $loopCount;
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
