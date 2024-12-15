<?php

/**
 * Unit tests for the Advent of Code Day 14 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-14 07:06:50
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-15 18:15:43
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day14;
use PHPUnit\Framework\TestCase;

final class Day14Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day14();
        $input = explode("\n", Helper::getSampleData('Day14Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 21);
    }
}
