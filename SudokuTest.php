<?php

declare(strict_types=1);

require_once 'SudokuSolver.php';

class SudokuTest
{
    private SudokuSolver $solver;

    public function __construct()
    {
        $this->solver = new SudokuSolver();
    }

    public function testSolver(): void
    {
        foreach ($this->dataProvider() as $label => $test) {
            echo PHP_EOL . '========== Test ' . $label . ' ===========' . PHP_EOL;

            $this->displaySolution($test['sudoku']);

            echo '============ Solution: ============' . PHP_EOL;

            $solution = $this->solver->solve($test['sudoku']);

            $this->displaySolution($solution);

            assert($test['solution'] === $solution);
        }
    }

    private function dataProvider(): iterable
    {
        yield 'case #1' => [
            'sudoku'   => [
                [1, null, 4, 3, 7, null, null, null, null],
                [null, 7, null, null, null, 4, null, null, null],
                [null, 6, 2, null, 8, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, 2, 7, 4, 9, null],
                [null, null, 9, null, null, null, null, 1, null],
                [3, null, null, 9, 1, null, 6, null, null],
                [null, 2, null, null, null, null, null, 8, null],
                [7, null, 6, 8, 3, null, null, 2, null],
            ],
            'solution' => [
                [1, 5, 4, 3, 7, 9, 8, 6, 2],
                [8, 7, 3, 2, 6, 4, 9, 5, 1],
                [9, 6, 2, 5, 8, 1, 7, 4, 3],
                [2, 1, 7, 4, 9, 8, 5, 3, 6],
                [6, 3, 5, 1, 2, 7, 4, 9, 8],
                [4, 8, 9, 6, 5, 3, 2, 1, 7],
                [3, 4, 8, 9, 1, 2, 6, 7, 5],
                [5, 2, 1, 7, 4, 6, 3, 8, 9],
                [7, 9, 6, 8, 3, 5, 1, 2, 4],
            ],
        ];

        yield 'case #2' => [
            'sudoku'   => [
                [5, 3, null, null, 7, null, null, null, null],
                [6, null, null, 1, 9, 5, null, null, null],
                [null, 9, 8, null, null, null, null, 6, null],
                [8, null, null, null, 6, null, null, null, 3],
                [4, null, null, 8, null, 3, null, null, 1],
                [7, null, null, null, 2, null, null, null, 6],
                [null, 6, null, null, null, null, 2, 8, null],
                [null, null, null, 4, 1, 9, null, null, 5],
                [null, null, null, null, 8, null, null, 7, 9],
            ],
            'solution' => [
                [5, 3, 4, 6, 7, 8, 9, 1, 2],
                [6, 7, 2, 1, 9, 5, 3, 4, 8],
                [1, 9, 8, 3, 4, 2, 5, 6, 7],
                [8, 5, 9, 7, 6, 1, 4, 2, 3],
                [4, 2, 6, 8, 5, 3, 7, 9, 1],
                [7, 1, 3, 9, 2, 4, 8, 5, 6],
                [9, 6, 1, 5, 3, 7, 2, 8, 4],
                [2, 8, 7, 4, 1, 9, 6, 3, 5],
                [3, 4, 5, 2, 8, 6, 1, 7, 9],
            ],
        ];

        yield 'case #3' => [
            'sudoku'   => [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [6, null, null, 1, 9, null, null, null, null],
                [null, 9, 8, null, null, null, null, 6, null],
                [8, null, null, null, 6, null, null, null, 3],
                [4, null, null, 8, null, 3, null, null, 1],
                [7, null, null, null, 2, null, null, null, 6],
                [null, 6, null, null, null, null, 2, null, null],
                [null, null, null, 4, 1, 9, null, null, 5],
                [null, null, null, null, 8, null, null, 7, null],
            ],
            'solution' => [],
        ];
    }

    private function displaySolution(array $solution): void
    {
        if ($solution === []) {
            echo 'None found.';

            return;
        }

        foreach ($solution as $row) {
            foreach ($row as $column) {
                echo sprintf('[%s] ', $column ?? ' ');
            }

            echo PHP_EOL;
        }
    }
}

$testSuite = new SudokuTest();
$testSuite->testSolver();
