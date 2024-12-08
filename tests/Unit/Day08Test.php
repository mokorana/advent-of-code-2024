<?php

/**
 * Unit tests for the Advent of Code Day 08 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-08 11:29:44
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-08 16:47:25
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day08;
use PHPUnit\Framework\TestCase;

final class Day08Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day08();
        $input = explode("\n", Helper::getSampleData('Day08Sample.data'));

        $this->assertSame($dayPuzzle->solvePart($input), 14);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day08();
        $input = explode("\n", Helper::getSampleData('Day08Sample.data'));

        $this->assertSame($dayPuzzle->solvePart($input, true), 34);
    }
}
