<?php

/**
 * Solution for Advent of Code Day 11.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-11 08:39:26
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-11 11:39:24
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day11 extends AbstractDay
{
    /**
     * Calculates the "blinking" value of a stone recursively.
     *
     * @param string $stone The current stone value as a string.
     * @param int $times The number of recursive steps to process.
     * @return int The final result after processing.
     */
    public function blink(string $stone, int $times): int
    {
        if ($times === 0) {
            return 1;
        }

        static $cache = [];
        if (isset($cache["$stone-$times"])) {
            return $cache["$stone-$times"];
        }

        if ($stone === '0') {
            $result = $this->blink('1', $times - 1);
        } elseif (strlen($stone) % 2 === 0) {
            $left = substr($stone, 0, (int) (strlen($stone) / 2));
            $right = (string) ((int) substr($stone, (int) (strlen($stone) / 2)));

            $result = $this->blink($left, $times - 1) + $this->blink($right, $times - 1);
        } else {
            $newStone = (int)$stone * 2024;
            $result = $this->blink((string)$newStone, $times - 1);
        }

        $cache["$stone-$times"] = $result;

        return $result;
    }

    /**
     * Main solution function to handle input and return results for both parts.
     *
     * @return array<string, int>
     */
    public function solve(): array
    {
        $stones = explode(' ', $this->getInputString());

        $pt1 = 0;
        $pt2 = 0;
        foreach ($stones as $stone) {
            $pt1 += $this->blink($stone, 25);
            $pt2 += $this->blink($stone, 75);
        }

        return [
            "Part 1" => $pt1,
            "Part 2" => $pt2
        ];
    }
}
