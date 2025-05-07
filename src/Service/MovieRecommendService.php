<?php

namespace App\Service;

readonly class MovieRecommendService
{
    public function __construct(
        private array $movies = []
    )
    {
    }

    public static function fromFile(string $path = __DIR__ . '/External/movies.php'): self
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException("File not found: $path");
        }

        $movies = require $path;

        if (!is_array($movies)) {
            throw new \RuntimeException("File $path doesn't return array");
        }

        return new self($movies);
    }

    public function recommend3RandomMovies(): array
    {

    }

    public function recommendByLetterWAndEvenLength(): array
    {

    }

    public function recommendMultiWordTitles(): array
    {

    }
}