<?php

namespace App\Tests\Service;

use App\Service\MovieRecommendService;
use PHPUnit\Framework\TestCase;

final class MovieRecommendServiceTest extends TestCase
{
    private const string MOVIES_FILE_PATH = __DIR__ . '/../../src/External/movies.php';
    private array $movies;
    private MovieRecommendService $service;

    protected function setUp(): void
    {
        $this->movies = require self::MOVIES_FILE_PATH;
        $this->service = MovieRecommendService::fromFile(self::MOVIES_FILE_PATH);
    }

    public function testRecommend3RandomMovies()
    {
        $results = $this->service->recommend3RandomMovies();

        if(count($this->movies) >= 3) {
            $this->assertCount(3, $results);
        } else {
            $this->assertCount(count($this->movies), $results);
        }

        foreach ($results as $title) {
            $this->assertContains($title, $this->movies);
        }
    }

    public function testRecommendByLetterWAndEvenLength()
    {
        $results = $this->service->recommendByLetterWAndEvenLength();

        foreach ($results as $title) {
            $this->assertStringStartsWith('W', $title);
            $this->assertEquals(0, strlen($title) % 2);
        }
    }

    public function testRecommendMultiWordTitles()
    {
        $results = $this->service->recommendMultiWordTitles();

        foreach ($results as $title) {
            $this->assertGreaterThan(1, str_word_count($title));
        }
    }

    public function testFileFromMissingFile(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        MovieRecommendService::fromFile("non_existing_file.php");
    }

    public function testFileFromWrongFormat(): void
    {
        $invalidFile = __DIR__ . '/../Stub/invalid_movies.php';

        $this->expectException(\RuntimeException::class);
        MovieRecommendService::fromFile($invalidFile);
    }
}