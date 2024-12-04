<?php

/**
 * Unit tests for the Advent of Code Day 03 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-03 08:25:26
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-04 09:37:36
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day03;
use PHPUnit\Framework\TestCase;

final class Day03Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day03();
        $input = preg_split('/mul\\(/', Helper::getSampleData('Day03Sample1.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 161);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day03();
        $input = preg_split('/do\(\)/', Helper::getSampleData('Day03Sample2.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 48);
    }
}
