<?php

/**
 * Unit tests for the Advent of Code Day 17 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-17 14:23:17
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-17 16:58:25
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day17;
use PHPUnit\Framework\TestCase;

final class Day17Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day17();
        $input = explode("\n\n", Helper::getSampleData('Day17Sample1.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), '4,6,3,5,6,3,5,2,1,0');
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day17();
        $input = explode("\n\n", Helper::getSampleData('Day17Sample2.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 117440);
    }
}
