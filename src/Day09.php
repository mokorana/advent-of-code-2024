<?php

/**
 * Solution for Advent of Code Day 09.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-09 09:39:02
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-09 15:12:14
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day09 extends AbstractDay
{
    /**
     * Solve part 1 & 2 of the challenge.
     *
     * @param string $input The input string containing disk and space information.
     * @param bool $pt2 Indicates whether to use Part 2 logic.
     * @return int The calculated result based on the input.
     */
    public function solvePart(string $input, bool $pt2 = false): int
    {
        $files = [];
        $spaces = [];
        $disk = [];
        $pos = 0;

        // Parse input data into files, spaces and disk
        for ($i = 0, $fileId = 0; $i < strlen($input);) {
            $fileSz = (int)$input[$i];

            if ($pt2) {
                $files[] = [$pos, $fileSz, $fileId];
            }

            for ($j = 0; $j < $fileSz; $j++) {
                $disk[] = $fileId;
                if (!$pt2) {
                    $files[] = [$pos, 1, $fileId];
                }
                $pos++;
            }
            $i++;
            $fileId++;

            if ($i < strlen($input)) {
                $spaceSz = (int)$input[$i];
                $spaces[] = [$pos, $spaceSz];
                for ($j = 0; $j < $spaceSz; $j++) {
                    $disk[] = null;
                    $pos++;
                }
                $i++;
            }
        }

        // Rearrange files into available spaces
        foreach (array_reverse($files) as $file) {
            [$filePos, $fileSz, $fileId] = $file;

            foreach ($spaces as $s => $space) {
                [$spacePos, $spaceSz] = $space;

                if ($spacePos < $filePos && $fileSz <= $spaceSz) {
                    for ($i = 0; $i < $fileSz; $i++) {
                        $disk[$filePos + $i] = null;
                        $disk[$spacePos + $i] = $fileId;
                    }
                    $spaces[$s] = [$spacePos + $fileSz, $spaceSz - $fileSz];
                    break;
                }
            }
        }

        // Calculate the final sum
        $sum = 0;
        foreach ($disk as $fileId => $file) {
            if ($file !== null) {
                $sum += $fileId * $file;
            }
        }

        return $sum;
    }

    /**
     * Main solution function to handle input and return results for both parts.
     *
     * @return array<string, int>
     */
    public function solve(): array
    {
        $input = $this->getInputString();

        return [
            "Part 1" => $this->solvePart($input),
            "Part 2" => $this->solvePart($input, true)
        ];
    }
}
