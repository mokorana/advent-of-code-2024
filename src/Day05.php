<?php

/**
 * Solution for Advent of Code Day 05.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-05 08:21:05
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-05 13:21:57
 *
 * @package Aoc
 */

namespace Aoc;

/**
 * The class is used, it's just called dynamically from App.php.
 *
 * @psalm-suppress UnusedClass
 */
class Day05 extends AbstractDay
{
    private function parseData(array $data): array
    {
        $rules = explode("\n", $data[0]);
        $parsedRules = array_map(
            fn(string $rule): array => explode('|', $rule),
            $rules
        );

        $updates = explode("\n", $data[1]);
        $parsedUpdates = array_map(
            fn(string $update): array => explode(',', $update),
            $updates
        );

        // Short form
        // $rules = array_map(fn(string $rule): array => explode('|', $rule), explode("\n", $data[0]));
        // $updates = array_map(fn(string $update): array => explode(',', $update), explode("\n", $data[1]));

        return array($parsedRules, $parsedUpdates);
    }

    /**
     * Validate updates against the rules and return false updates.
     *
     * @param array $updates
     * @param array $rules
     * @return array
     */
    private function getFalseUpdates(array $updates, array $rules): array
    {
        $falseUpdates = [];

        foreach ($updates as $update) {
            if (!$this->isUpdateValid($update, $rules)) {
                $falseUpdates[] = $update;
            }
        }

        return $falseUpdates;
    }

    /**
     * Check if an update is valid based on the rules.
     *
     * @param array $update
     * @param array $rules
     * @return bool
     */
    private function isUpdateValid(array $update, array $rules): bool
    {
        foreach ($update as $pageKey => $page) {
            $pageRules = array_filter($rules, fn(array $rule) => in_array($page, $rule));
            foreach ($pageRules as $rule) {
                $ruleIndex = array_search($rule[1], $update);

                if ($ruleIndex !== false && $ruleIndex < $pageKey) {
                    return false; // Found invalid dependency
                }
            }
        }

        return true;
    }

    /**
     * Solve part 1 of the challenge.
     *
     * @param array<string> $lines
     * @return int
     */
    public function solvePart1(array $lines): int
    {
        [$rules, $updates] = $this->parseData($lines);

        $middlePageValues = [];
        foreach ($updates as $update) {
            if ($this->isUpdateValid($update, $rules)) {
                $middlePageValues[] = $update[intval(count($update) / 2)];
            }
        }

        return (int)array_sum($middlePageValues);
    }

    /**
     * Solve part 2 of the challenge.
     *
     * @param array<string> $lines
     * @return int
     */
    public function solvePart2(array $lines): int
    {
        [$rules, $updates] = $this->parseData($lines);

        // Get invalid updates
        $falseUpdates = $this->getFalseUpdates($updates, $rules);

        // Sort invalid updates and get middle page values
        $middlePageValues = [];
        foreach ($falseUpdates as $update) {
            $sortedUpdate = $this->topologicalSort($update, $rules);
            $middlePageValues[] = $sortedUpdate[intval(count($sortedUpdate) / 2)];
        }

        return (int)array_sum($middlePageValues);
    }

    /**
     * Topologically sort an update based on rules.
     *
     * @param array $update
     * @param array $rules
     * @return array
     */
    private function topologicalSort(array $update, array $rules): array
    {
        $graph = [];
        $inDegree = [];
        $nodes = array_flip($update);

        // Build the graph and calculate in-degrees
        foreach ($rules as [$x, $y]) {
            if (isset($nodes[$x], $nodes[$y])) {
                $graph[$x][] = $y;
                $inDegree[$y] = ($inDegree[$y] ?? 0) + 1;
                $inDegree[$x] = $inDegree[$x] ?? 0;
            }
        }

        // Initialize queue with nodes having no incoming edges
        $queue = array_filter(array_keys($nodes), fn($node) => ($inDegree[$node] ?? 0) === 0);

        // Perform topological sorting
        $sortedUpdate = [];
        while (!empty($queue)) {
            $current = array_shift($queue);
            $sortedUpdate[] = $current;

            foreach ($graph[$current] ?? [] as $neighbor) {
                $inDegree[$neighbor]--;
                if ($inDegree[$neighbor] === 0) {
                    $queue[] = $neighbor;
                }
            }
        }

        return $sortedUpdate;
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
