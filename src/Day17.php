<?php

/**
 * Solution for Advent of Code Day 17.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-17 14:23:17
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-17 21:01:45
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day17 extends AbstractDay
{
    /**
     * Parse input data into registers and program instructions.
     *
     * @param array<string> $parts An array with two strings: registers and program instructions.
     * @return array{int, int, int, array<int>}
     */
    private function parseInput(array $parts): array
    {
        [$registers, $program] = $parts;

        preg_match_all('/-?\d+/', $registers, $matches);
        /** @psalm-suppress PossiblyUndefinedArrayOffset */
        [$regA, $regB, $regC] = array_map('intval', $matches[0]);
        $program = array_map('intval', explode(",", explode(":", $program)[1]));

        return [$regA, $regB, $regC, $program];
    }

    /**
     * Execute the program instructions.
     *
     * @param array<int> $program The program instructions
     * @param int $regA Register A value
     * @param int $regB Register B value
     * @param int $regC Register C value
     * @return array<int> Output produced by the program
     */
    private function run(array $program, int $regA, int $regB, int $regC): array
    {
        $ip = 0;
        $output = [];

        while ($ip < count($program)) {
            $code = $program[$ip];
            $op = $program[$ip + 1];

            // Get the combination based on operand
            $combo = match ($op) {
                0, 1, 2, 3 => $op,
                4 => $regA,
                5 => $regB,
                6 => $regC,
                default => -1,
            };

            switch ($code) {
                case 0:
                    $regA = (int) ($regA / (2 ** $combo));
                    $ip += 2;
                    break;
                case 1:
                    $regB ^= $op;
                    $ip += 2;
                    break;
                case 2:
                    $regB = $combo % 8;
                    $ip += 2;
                    break;
                case 3:
                    $ip = ($regA !== 0) ? $op : $ip + 2;
                    break;
                case 4:
                    $regB ^= $regC;
                    $ip += 2;
                    break;
                case 5:
                    $output[] = $combo % 8;
                    $ip += 2;
                    break;
                case 6:
                    $regB = (int) ($regA / (2 ** $combo));
                    $ip += 2;
                    break;
                case 7:
                    $regC = (int) ($regA / (2 ** $combo));
                    $ip += 2;
                    break;
                default:
                    throw new \RuntimeException("Invalid code encountered: {$code}");
            }
        }

        return $output;
    }


    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $parts The grid lines.
     * @return string
     */
    public function solvePart1(array $parts): string
    {
        [$regA, $regB, $regC, $program] = $this->parseInput($parts);
        $pt1 = $this->run($program, $regA, $regB, $regC);

        return implode(',', $pt1);
    }

    /**
     * Solve part 2 of the challenge.
     *
     * @param array<string> $parts The grid lines.
     * @return int
     */
    public function solvePart2(array $parts): int
    {
        [, $regB, $regC, $program] = $this->parseInput($parts);
        $pt2 = 0;

        // Iterate backward through the program to find the correct seed ($pt2)
        for ($i = count($program) - 1; $i >= 0; $i--) {
            // Shift seed value left by 3 bits
            $pt2 <<= 3;

            // Increment seed until it produces the correct output
            while ($this->run($program, $pt2, $regB, $regC) !== array_slice($program, $i)) {
                $pt2++;
            }
        }

        return $pt2;
    }

    /**
     * Main solution function to handle input and return results for both parts.
     *
     * @return array<array-key, int|string>
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
