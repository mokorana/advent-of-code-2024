<?php

/**
 * Defines the abstract base class `AbstractDay`, which serves as a
 * blueprint for solving daily puzzles in the Advent of Code challenge.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-01 10:54:49
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-02 11:48:04
 *
 * @package Aoc
 */

namespace Aoc;

use Exception;

abstract class AbstractDay
{
    /**
     * Returns the solutions for the day's puzzle, in parts. This might either
     * be a string or an integer.
     *
     * @return (string|int)[]
     * @throws Exception
     */
    abstract public function solve(): array;

    /**
     * Returns the contents of the .data file for the respective day.
     *
     * @used-by Aoc\Day01
     * @return  string
     * @throws  Exception
     */
    protected function getInputString(): string
    {
        $className = get_class($this);
        preg_match('/Day\d\d?/', $className, $matches);
        $contents = file_get_contents(__DIR__ . "/$matches[0].data");
        if (is_bool($contents)) {
            throw new Exception(
                "Failed to read contents of " . __DIR__ . "/$matches[0].data"
            );
        }

        // Ensure no trailing newlines or spaces
        return rtrim($contents);
    }
}
