<?php

/**
 * Solution for Advent of Code Day 04.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-04 08:31:04
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-04 15:52:30
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day04 extends AbstractDay
{
    /**
     * Split input lines into arrays of characters.
     *
     * @param array<string> $lines The input lines.
     * @return array<array<string>> The split rows.
     */
    private function splitRows(array $lines): array
    {
        return array_map('str_split', $lines);
    }

    /**
     * Transform rows to columns for vertical matching.
     *
     * @param array<array<string>> $rows The grid rows.
     * @return array<array<string>> The transformed columns.
     */
    private function transformToColumns(array $rows): array
    {
        $columns = [];
        foreach (array_keys($rows[0]) as $colIndex) {
            $columns[] = array_column($rows, $colIndex);
        }
        return $columns;
    }

    /**
     * Collect diagonals from the grid.
     *
     * @param array<array<string>> $rows The grid rows.
     * @param bool $topLeftToBottomRight Whether to collect TL-BR diagonals.
     * @return array<string> The collected diagonals.
     */
    private function collectDiagonals(array $rows, bool $topLeftToBottomRight): array
    {
        $diagonals = [];

        foreach ($rows as $rowIndex => $row) {
            foreach (array_keys($row) as $colIndex) {
                // TL-BR diagonals start from top row or leftmost column
                // TR-BL diagonals start from top row or rightmost column
                $isStartingPoint = $topLeftToBottomRight
                ? ($rowIndex === 0 || $colIndex === 0)
                : ($rowIndex === 0 || $colIndex === count($row) - 1);

                if ($isStartingPoint) {
                    $diagonal = '';
                    $i = $rowIndex;
                    $j = $colIndex;

                    while (isset($rows[$i][$j])) {
                        $diagonal .= $rows[$i][$j];

                        // Adjust traversal direction based on diagonal type
                        $i++;
                        $j = (int) $colIndex; // Cast to integer before operations
                        $j += $topLeftToBottomRight ? 1 : -1;
                    }

                    $diagonals[] = $diagonal;
                }
            }
        }

        return $diagonals;
    }

    /**
     * Count matches for "XMAS" and "SAMX" in an array of strings.
     *
     * @param array<string>|array<array<string>> $grid The grid or flat list to search.
     * @return int The number of matches found.
     */
    private function countMatches(array $grid): int
    {
        $sum = 0;
        foreach ($grid as $line) {
            $joined = is_array($line) ? implode('', $line) : $line;
            $sum += preg_match_all('/XMAS/i', $joined);
            $sum += preg_match_all('/SAMX/i', $joined);
        }
        return $sum;
    }

    /**
     * Find all valid "A" anchors with enough space around them.
     *
     * @param array<array<string>> $rows The grid rows.
     * @return array<array<int>> The coordinates of valid anchors.
     */
    private function findValidAnchors(array $rows): array
    {
        $anchors = [];
        for ($row = 1, $numRows = count($rows) - 1; $row < $numRows; $row++) {
            for ($col = 1, $numCols = count($rows[$row]) - 1; $col < $numCols; $col++) {
                if ($rows[$row][$col] === 'A') {
                    $anchors[] = [$row, $col];
                }
            }
        }
        return $anchors;
    }

    /**
     * Solve part 1 of the challenge: Count matches for XMAS and SAMX.
     *
     * @param array<string> $lines The grid lines.
     * @return int The total number of matches.
     */
    public function solvePart1(array $lines): int
    {
        $rows = $this->splitRows($lines);
        $columns = $this->transformToColumns($rows);
        $diagonals = array_merge(
            $this->collectDiagonals($rows, true),  // Top-left to Bottom-right
            $this->collectDiagonals($rows, false) // Top-right to Bottom-left
        );

        return $this->countMatches($rows) +
               $this->countMatches($columns) +
               $this->countMatches($diagonals);
    }

    /**
     * Count valid patterns around anchors.
     *
     * @param array<array<string>> $rows The grid rows.
     * @param array<array<int>> $anchors The valid "A" anchors.
     * @return int The number of valid patterns.
     */
    private function countValidPatterns(array $rows, array $anchors): int
    {
        $sum = 0;
        foreach ($anchors as [$row, $col]) {
            $corners = [
                [-1, -1], [-1, 1],
                [1, -1], [1, 1]
            ];

            $mCount = 0;
            $sCount = 0;
            foreach ($corners as [$rOffset, $cOffset]) {
                $char = $rows[$row + $rOffset][$col + $cOffset];
                $char === 'M' ? $mCount++ : ($char === 'S' ? $sCount++ : null);
            }

            if (
                $mCount === 2 && $sCount === 2 &&
                $rows[$row - 1][$col - 1] !== $rows[$row + 1][$col + 1]
            ) {
                $sum++;
            }
        }
        return $sum;
    }

    /**
     * Solve part 2 of the challenge: Count matches of X-MAS patterns
     *
     * @param array<string> $lines The grid lines.
     * @return int The total number of valid "A" patterns.
     */
    public function solvePart2(array $lines): int
    {
        $rows = $this->splitRows($lines);
        $validAnchors = $this->findValidAnchors($rows);

        return $this->countValidPatterns($rows, $validAnchors);
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
