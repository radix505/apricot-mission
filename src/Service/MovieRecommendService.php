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
        if (count($this->movies) <= 3) {
            return $this->movies;
        }

        $keys = array_rand($this->movies, 3);
        return array_map(fn($key) => $this->movies[$key], (array)$keys);
    }

    public function recommendByLetterWAndEvenLength(): array
    {
        return $this->filterMoviesArray(
            fn(string $title) => str_starts_with($title, 'W') &&
                strlen($title) % 2 === 0
        );
    }

    public function recommendMultiWordTitles(): array
    {
        return $this->filterMoviesArray(fn(string $title) => str_word_count($title) > 1);
    }

    private function filterMoviesArray(callable $filter): array
    {
        return array_values(array_filter(
            $this->movies,
            $filter
        ));
    }
}