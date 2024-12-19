<?php

/**
 * Unit tests for the Advent of Code Day 19 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-19 09:15:39
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-19 11:21:59
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day19;
use PHPUnit\Framework\TestCase;

final class Day19Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day19();
        $input = explode("\n\n", Helper::getSampleData('Day19Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 6);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day19();
        $input = explode("\n\n", Helper::getSampleData('Day19Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 16);
    }
}
