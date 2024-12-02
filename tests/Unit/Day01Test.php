<?php

/**
 * Unit tests for the Advent of Code Day 01 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-01 11:06:58
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-02 11:58:53
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day01;
use PHPUnit\Framework\TestCase;

final class Day01Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day01();
        $input = explode("\n", Helper::getSampleData('Day01Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 11);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day01();
        $input = explode("\n", Helper::getSampleData('Day01Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 31);
    }
}
