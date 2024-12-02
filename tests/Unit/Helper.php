<?php

/**
 * Helper class for retrieving sample data in unit tests.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-02 10:45:48
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-02 11:56:54
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use PHPUnit\Framework\TestCase;

class Helper
{
    /**
     * Retrieves the contents of a specified file in the test directory.
     *
     * @param  string $filename The name of the file to read.
     * @return string The contents of the file.
     * @throws \RuntimeException If the file cannot be read.
     * @throws PHPUnit\Framework\SkippedTestError If the file is encrypted and not unlocked.
     */
    public static function getSampleData(string $filename): string
    {
        $contents = file_get_contents(__DIR__ . "/$filename");

        if (is_bool($contents)) {
            throw new \RuntimeException(
                "Failed to read contents of " . __DIR__ . "/$filename, " .
                "possible because it does not exist."
            );
        }

        if (str_contains($contents, 'GITCRYPT')) {
            TestCase::markTestSkipped(
                "Failed to read contents of " . __DIR__ . "/$filename, " .
                "probably because 'git-crypt unlock' has not been run. " .
                "See README.md for more detail."
            );
        }

        return rtrim($contents);
    }
}
