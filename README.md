My attempts at the [Advent of Code 2024](https://adventofcode.com/2024) challenges in [PHP](https://www.php.net).

## Solutions

| Day | Name                  | Code                             | Time †       | GitHub Action Output                                                                                                                                                                                              |
| --- | --------------------- | -------------------------------- | ------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| 01  | Historian Hysteria    | [src/Day01.php](./src/Day01.php) | `0.003701s`  | [![Day-01](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-01.yml/badge.svg?branch=main)](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-01.yml?query=branch%3Amain) |
| 02  | Red-Nosed Reports     | [src/Day02.php](./src/Day01.php) | `0.014919s`  | [![Day-02](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-02.yml/badge.svg?branch=main)](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-02.yml?query=branch%3Amain) |
| 03  | Mull It Over          | [src/Day03.php](./src/Day03.php) | `0.001430s`  | [![Day-03](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-03.yml/badge.svg?branch=main)](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-03.yml?query=branch%3Amain) |
| 04  | Ceres Search          | [src/Day04.php](./src/Day04.php) | `0.018255s`  | [![Day-04](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-04.yml/badge.svg?branch=main)](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-04.yml?query=branch%3Amain) |
| 05  | Print Queue           | [src/Day05.php](./src/Day05.php) | `3.213716s`  | [![Day-05](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-05.yml/badge.svg?branch=main)](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-05.yml?query=branch%3Amain) |
| 06  | Guard Gallivant       | [src/Day06.php](./src/Day06.php) | `70.499905s` | [![Day-06](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-06.yml/badge.svg?branch=main)](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-06.yml?query=branch%3Amain) |
| 07  | Bridge Repair         | [src/Day07.php](./src/Day07.php) | `4.580957s`  | [![Day-07](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-07.yml/badge.svg?branch=main)](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-07.yml?query=branch%3Amain) |
| 08  | Resonant Collinearity | [src/Day08.php](./src/Day08.php) | `0.003884s`        | [![Day-08](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-08.yml/badge.svg?branch=main)](https://github.com/mokorana/advent-of-code-2024/actions/workflows/Day-08.yml?query=branch%3Amain) |

† The measured execution time in GitHub Actions

## Installation

### Installing on your machine

Installation with vary on each system. For a full environment the following dependencies should be installed:

- [PHP](https://www.php.net) 8.3
- [Composer](https://getcomposer.org) 2.6
- [Xdebug](https://xdebug.org) 3.3

### Installing with Docker

Using [Docker](https://www.docker.com/get-started/) avoids the complexity of installing the dependencies listed above.

Once Docker is installed, a Docker image can be built by running:

```shell
make docker-build
```

Once built, an interactive shell with the project directory mounted can be started by running:

```shell
make shell
```

## How to run

Before running the code, the dependencies must be installed by running:

```shell
composer install
```

All puzzles can be executed by running:

```shell
php src/main.php
```

Individual puzzles can be executed by adding the day-number:

```shell
php src/main.php 01
```

The solutions can be benchmarked by adding the flag `-b`:

```shell
php src/main.php 01 -b
```

### Why is the input data encrypted?

Note that the input data included in this repository have been encrypted, and exist purely for personal use.
This is because the input data is the [sole property of Advent of Code](https://adventofcode.com/2024/about#legal), and is not licensed for reproduction or distribution.
To test with your own input, replace the contents of the file `src/Day**.data` with your own inputs from [adventofcode.com](https://adventofcode.com).

If you somehow are in possession of the encryption key, you can unlock it using [git-crypt](https://github.com/AGWA/git-crypt) by running:

```shell
echo "${BASE64_ENCODED_KEY}" | base64 -d | git-crypt unlock -
```

## How to develop

As mentioned above, the code for each puzzle can be run individually. But this project has additional tools to help with development.

### Generate Quiz Files

Some files have to be generated for every new quiz day. Those files can be automatically generated.

```shell
make generate 01 'name of quiz'
```

### Tests

Test-driven-development using unit tests can help with solving a puzzle by ensuring individual functions work as expected. Tests can be added in `tests/Unit/*` and run using [PHPUnit](http://phpunit.de). The flags `--testdox` and `--colors` can help make the output more legible:

```shell
vendor/bin/phpunit tests/Unit/Day01Test.php --testdox --colors
```

This can be run quickly for all tests from the Makefile:

```shell
make tests
```

Note that some of the test data includes sample data from adventofcode.com, which have been encrypted for the same legal reasons mentioned above in "Why is the input data encrypted?". These tests will be skipped when attempting to run the tests.

### Linting & Static Analysis

Following code standards can help make the code more legible and running static analysis tools can spot issues in the code. This project comes with [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and [Psalm](https://psalm.dev):

```shell
vendor/bin/phpcs -p --standard=PSR12 src/ tests/
vendor/bin/psalm --show-info=true
```

These can be run quickly from the Makefile:

```shell
make lint
```
