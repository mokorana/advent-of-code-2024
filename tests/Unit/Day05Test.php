<?php

/**
 * Unit tests for the Advent of Code Day 05 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-05 08:21:05
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-05 11:46:34
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day05;
use PHPUnit\Framework\TestCase;

final class Day05Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day05();
        $input = explode("\n\n", Helper::getSampleData('Day05Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 143);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day05();
        $input = explode("\n\n", Helper::getSampleData('Day05Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 123);
    }
}
