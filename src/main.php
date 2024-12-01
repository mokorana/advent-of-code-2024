<?php
/**
 * Bootstrap file for the Advent of Code application.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-01 11:04:30
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-01 11:06:00
 *
 * @package Aoc
 */

use Aoc\App;

require __DIR__ . '/../vendor/autoload.php';

(new App())->run($argv);
