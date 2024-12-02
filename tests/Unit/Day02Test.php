<?php

/**
 * Unit tests for the Advent of Code Day 01 solution.
 *
 * @Author: Stefan Koch
 * @Date:   2024-12-02 12:21:47
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-02 15:23:28
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day02;
use PHPUnit\Framework\TestCase;

final class Day02Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day02();
        $input = explode("\n", Helper::getSampleData('Day02Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 2);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day02();
        $input = explode("\n", Helper::getSampleData('Day02Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 4);
    }
}
