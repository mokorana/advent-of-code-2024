<?php

/**
 * Unit tests for the Advent of Code Day 18 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-18 19:00:43
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-18 21:24:13
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day18;
use PHPUnit\Framework\TestCase;

final class Day18Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day18();
        $input = explode("\n", Helper::getSampleData('Day18Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 146);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day18();
        $input = explode("\n", Helper::getSampleData('Day18Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), '2,0');
    }
}
