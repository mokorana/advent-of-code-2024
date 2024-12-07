<?php

/**
 * Unit tests for the Advent of Code Day 07 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-07 08:03:54
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-07 12:17:36
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day07;
use PHPUnit\Framework\TestCase;

final class Day07Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day07();
        $input = explode("\n", Helper::getSampleData('Day07Sample.data'));

        $this->assertSame($dayPuzzle->solvePart($input, false), 3749);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day07();
        $input = explode("\n", Helper::getSampleData('Day07Sample.data'));

        $this->assertSame($dayPuzzle->solvePart($input, true), 11387);
    }
}
