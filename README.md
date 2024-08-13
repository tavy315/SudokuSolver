# SudokuSolver (08/2024)

This is a backtrack-sudoku-solver implemented in PHP.

## Prerequisites

* PHP
* an unsolved sudoku

## How to use

Sudokus are of the type `Array` of `Array` of `Nullable Integer`. Every line of the sudoku is an `Array` of `Nullable Integer`. Every free gap is `Nothing` (`null`) and every composed number an `Integer` value.

The `solve` function takes one value (a sudoku) and is a backtracking-strategy that uses the empty field with the least alternatives first (`getBestNothing`).

It contains also a `SudokuTest` with 2 examples of unresolved sudoku (testSolver).
