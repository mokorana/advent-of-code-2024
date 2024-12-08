<?php

/**
 * Solution for Advent of Code Day 08.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-08 11:29:44
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-08 16:45:10
 *
 * @package Aoc
 */

// phpcs:disable PSR1.Classes.ClassDeclaration

namespace Aoc;

/**
 * Represents an antenna with its position and frequency.
 *
 * @psalm-suppress UndefinedClass This class is defined in the same file.
 */
class Antenna
{
    /**
     * Constructor for the Antenna class.
     *
     * @param int $row The row position of the antenna.
     * @param int $col The column position of the antenna.
     * @param string $frequency The frequency associated with the antenna.
     */
    public function __construct(
        public int $row,
        public int $col,
        public string $frequency,
    ) {
    }
}

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day08 extends AbstractDay
{
    /**
     * Extracts antenna objects from the grid.
     *
     * @param array<string> $grid The input grid as an array of strings.
     * @param int $width The width of the grid.
     * @param int $height The height of the grid.
     * @return Antenna[] An array of Antenna objects extracted from the grid.
     */
    private function extractAntennas(array $grid, int $width, int $height): array
    {
        $antennas = [];
        for ($r = 0; $r < $height; $r++) {
            for ($c = 0; $c < $width; $c++) {
                if ($grid[$r][$c] === '.') {
                    continue;
                }
                $antennas[] = new Antenna($r, $c, $grid[$r][$c]);
            }
        }

        return $antennas;
    }

    /**
     * Counts the unique antinodes for a set of antennas.
     *
     * @param Antenna[] $antennas The array of antennas to analyze.
     * @param int $width The width of the grid.
     * @param int $height The height of the grid.
     * @param bool $pt2 Whether part 2 rules apply.
     * @return int The number of unique antinodes.
     */
    private function countUniqueAntinodes(array $antennas, int $width, int $height, bool $pt2 = false): int
    {
        $antinodes = [];

        foreach ($antennas as $a) {
            foreach ($antennas as $b) {
                // Skip when frequencies are not the same
                if ($a->frequency !== $b->frequency || ($a === $b)) {
                    continue;
                }

                // Check if nodes are in the grid
                $rd = ($a->row - $b->row);
                $cd = ($a->col - $b->col);
                $r = $pt2 ? $b->row : $a->row;
                $c = $pt2 ? $b->col : $a->col;

                do {
                    $r += $rd;
                    $c += $cd;
                    if ($r < 0 || $c < 0 || $r >= $height || $c >= $width) {
                        break;
                    }
                    $antinodes["$r-$c"] = true;
                } while ($pt2);
            }
        }

        return count($antinodes);
    }

    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @return int The result for part 1 & 2.
     */
    public function solvePart(array $lines, bool $pt2 = false): int
    {
        $height = count($lines);
        $width = strlen($lines[0]);
        $antennas = $this->extractAntennas($lines, $width, $height);

        return $this->countUniqueAntinodes($antennas, $width, $height, $pt2);
    }

    /**
     * Solve part 2 of the challenge.
     *
     * @param array<string> $lines The grid lines.
     * @return int The result for part 2.
     */
    public function solvePart2(array $lines): int
    {
        $height = count($lines);
        $width = strlen($lines[0]);

        $antennas = $this->extractAntennas($lines, $width, $height);

        $antinodes = $this->countUniqueAntinodes($antennas, $width, $height, true);

        return $antinodes;
    }

    /**
     * Main solution function to handle input and return results for both parts.
     *
     * @return array<string, int> The results for part 1 and part 2.
     */
    public function solve(): array
    {
        $lines = explode("\n", $this->getInputString());
        return [
            "Part 1" => $this->solvePart($lines),
            "Part 2" => $this->solvePart($lines, true)
        ];
    }
}
