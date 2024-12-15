<?php

/**
 * Unit tests for the Advent of Code Day 13 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-13 07:16:33
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-13 09:45:07
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day13;
use PHPUnit\Framework\TestCase;

final class Day13Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day13();
        $input = explode("\n\n", Helper::getSampleData('Day13Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 480);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day13();
        $input = explode("\n\n", Helper::getSampleData('Day13Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 875318608908);
    }
}
