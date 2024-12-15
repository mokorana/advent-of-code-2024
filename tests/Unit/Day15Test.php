<?php

/**
 * Unit tests for the Advent of Code Day 15 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-15 11:11:26
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-15 15:35:03
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day15;
use PHPUnit\Framework\TestCase;

final class Day15Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day15();
        $input = explode("\n\n", Helper::getSampleData('Day15Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 10092);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day15();
        $input = explode("\n\n", Helper::getSampleData('Day15Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 9021);
    }
}
