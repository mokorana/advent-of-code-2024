<?php

/**
 * Unit tests for the Advent of Code Day 11 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-11 08:39:26
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-11 11:29:31
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day11;
use PHPUnit\Framework\TestCase;

final class Day11Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day11();
        $result = $dayPuzzle->solve();

        $this->assertSame($result["Part 1"], 203609);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day11();
        $result = $dayPuzzle->solve();

        $this->assertSame($result["Part 2"], 240954878211138);
    }
}
