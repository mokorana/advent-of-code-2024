<?php

/**
 * Unit tests for the Advent of Code Day 04 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-04 08:31:04
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-04 11:53:26
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day04;
use PHPUnit\Framework\TestCase;

final class Day04Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day04();
        $input = explode("\n", Helper::getSampleData('Day04Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 18);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day04();
        $input = explode("\n", Helper::getSampleData('Day04Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 9);
    }
}
