<?php

declare(strict_types=1);

class SudokuSolver
{
    private array $coordinateRange = [];
    private array $range = [];
    private int $size = 3;

    public function __construct()
    {
        $this->range = range(1, $this->size ** 2);
        $this->coordinateRange = range(0, $this->size ** 2 - 1);
    }

    // Sudoku solver filling the first empty field
    public function solve(array $sudoku): array
    {
        $next = $this->getBestNothing($sudoku);

        if ($next === null) {
            return $sudoku;
        }

        [$coordinate, $substitutes] = $next;

        foreach ($substitutes as $substitute) {
            $newSudoku = $this->substituteNothing($sudoku, $coordinate, $substitute);

            $solution = $this->solve($newSudoku);

            if ($solution !== []) {
                return $solution;
            }
        }

        return [];
    }

    // Simple strategy returning the first empty field with a suggestion
    private function createNumberList(array $list): array
    {
        return array_values(
            array_filter(
                $list,
                static fn($n): bool => $n !== null
            )
        );
    }

    // Strategy returning the empty field with the least alternatives with a suggestion
    private function getBestNothing(array $sudoku): ?array
    {
        $allCoordinates = [];
        foreach ($this->coordinateRange as $i) {
            foreach ($this->coordinateRange as $j) {
                $allCoordinates[] = [$i, $j];
            }
        }

        $nothingCoordinates = array_filter(
            $allCoordinates,
            static fn($coordinate): bool => $sudoku[$coordinate[1]][$coordinate[0]] === null
        );

        $sortedNothings = $this->sortByLength(
            array_map(
                fn($coordinate) => [
                    $coordinate,
                    $this->getPossibleSubstitutions($sudoku, $coordinate),
                ],
                $nothingCoordinates
            )
        );

        return $this->safeHead($sortedNothings);
    }

    private function getBoxNumbers(int $column, int $row, array $sudoku): array
    {
        $boxNumbers = [];
        $startRow = $row * $this->size;
        $startCol = $column * $this->size;

        for ($i = 0; $i < $this->size; ++$i) {
            for ($j = 0; $j < $this->size; ++$j) {
                $boxNumbers[] = $sudoku[$startRow + $i][$startCol + $j];
            }
        }

        return $this->createNumberList($boxNumbers);
    }

    private function getColumnNumbers($column, $sudoku): array
    {
        return $this->createNumberList(
            array_column($sudoku, $column)
        );
    }

    // Returns possible substitutions for a given empty field
    private function getPossibleSubstitutions(array $sudoku, array $coordinate): array
    {
        [$column, $row] = $coordinate;

        return array_values(
            array_intersect(
                array_diff(
                    $this->range,
                    $this->getRowNumbers($row, $sudoku)
                ),
                array_diff(
                    $this->range,
                    $this->getColumnNumbers($column, $sudoku)
                ),
                array_diff(
                    $this->range,
                    $this->getBoxNumbers(
                        intdiv($column, $this->size),
                        intdiv($row, $this->size),
                        $sudoku
                    )
                )
            )
        );
    }

    private function getRowNumbers(int $row, array $sudoku): array
    {
        return $this->createNumberList($sudoku[$row]);
    }

    private function safeHead(array $array): ?array
    {
        return $array[0] ?? null;
    }

    private function sortByLength(array $nothings): array
    {
        usort($nothings, static function (array $array1, array $array2): int {
            return count($array1[1]) <=> count($array2[1]);
        });

        return $nothings;
    }

    private function substituteNothing(array $sudoku, array $coordinate, int $substitute): array
    {
        [$row, $column] = $coordinate;

        $sudoku[$column][$row] = $substitute;

        return $sudoku;
    }
}
