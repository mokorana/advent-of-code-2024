<?php

/**
 * Solution for Advent of Code Day 13.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-13 07:16:33
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-15 18:18:17
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day13 extends AbstractDay
{
    /**
     * Parse the input data and extract relevant coordinates.
     *
     * @param array<string> $blocks Input data blocks.
     * @return array<array<string, array<string, int>>> Parsed data.
     */
    private function parseData(array $blocks): array
    {
        $parsedData = [];
        foreach ($blocks as $block) {
            if (
                preg_match('/Button A: X\+(\d+), Y\+(\d+)/', $block, $buttonA_matches) &&
                preg_match('/Button B: X\+(\d+), Y\+(\d+)/', $block, $buttonB_matches) &&
                preg_match('/Prize: X=(\d+), Y=(\d+)/', $block, $prize_matches)
            ) {
                $parsedData[] = [
                    'a' => ['x' => (int)$buttonA_matches[1], 'y' => (int)$buttonA_matches[2]],
                    'b' => ['x' => (int)$buttonB_matches[1], 'y' => (int)$buttonB_matches[2]],
                    'p' => ['x' => (int)$prize_matches[1], 'y' => (int)$prize_matches[2]],
                ];
            }
        }

        return $parsedData;
    }

    /**
     * Calculate the greatest common divisor (GCD) of two numbers.
     *
     * @param int $a First number.
     * @param int $b Second number.
     * @return int GCD of $a and $b.
     */
    private function gcd(int $a, int $b): int
    {
        while ($b !== 0) {
            [$a, $b] = [$b, $a % $b];
        }
        return $a;
    }

    /**
     * Calculate the least common multiple (LCM) of two numbers.
     *
     * @param int $a First number.
     * @param int $b Second number.
     * @return int LCM of $a and $b.
     */
    private function lcm(int $a, int $b): int
    {
        return (int)(($a * $b) / $this->gcd($a, $b));
    }

    /**
     * Calculate the total button presses required to reach the prize.
     *
     * @param int $ax Button A X-offset.
     * @param int $ay Button A Y-offset.
     * @param int $bx Button B X-offset.
     * @param int $by Button B Y-offset.
     * @param int $px Prize X-coordinate.
     * @param int $py Prize Y-coordinate.
     * @return int Total button presses or 0 if unreachable.
     */
    private function presses(int $ax, int $ay, int $bx, int $by, int $px, int $py): int
    {
        $ma = $this->lcm($ax, $ay);
        $mx = $ma / $ax;
        $my = $ma / $ay;

        $b = ($mx * $px - $my * $py) / ($mx * $bx - $my * $by);
        $a = ($px - $b * $bx) / $ax;

        return is_int($a) ? (int)(($a * 3) + $b) : 0;
    }


    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @return int
     */
    public function solvePart1(array $lines): int
    {
        $blocks = $this->parseData($lines);
        $pt1 = 0;

        foreach ($blocks as $data) {
            $a = $data['a'];
            $b = $data['b'];
            $p = $data['p'];

            for ($nA = 0; $nA <= 100; $nA++) {
                for ($nB = 0; $nB <= 100; $nB++) {
                    $currX = ($nA * $a['x']) + ($nB * $b['x']);
                    $currY = ($nA * $a['y']) + ($nB * $b['y']);

                    if ($currX === $p['x'] && $currY === $p['y']) {
                        $pt1 += ($nA * 3) + $nB;
                        break 2; // Exit both loops
                    }
                }
            }
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
        $blocks = $this->parseData($lines);
        $pt2 = 0;

        foreach ($blocks as $data) {
            $a = $data['a'];
            $b = $data['b'];
            $p = $data['p'];


            $xP = $p['x'] + 10000000000000;
            $yP = $p['y'] + 10000000000000;

            $pt2 += $this->presses($a['x'], $a['y'], $b['x'], $b['y'], $xP, $yP);
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
        $lines = explode("\n\n", $this->getInputString());
        return [
            "Part 1" => $this->solvePart1($lines),
            "Part 2" => $this->solvePart2($lines)
        ];
    }
}
