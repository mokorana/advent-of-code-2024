<?php
/**
 * Unit tests for the Advent of Code Day 01 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-01 11:06:58
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-01 11:09:41
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day01;
use PHPUnit\Framework\TestCase;

final class Day01Test extends TestCase
{
    public function testTrivialCaseOfDay01(): void
    {
        $dayPuzzle = new Day01();
        $this->assertSame($dayPuzzle->solvePart1([1000, 1020]), 1000 * 1020);
    }
}

