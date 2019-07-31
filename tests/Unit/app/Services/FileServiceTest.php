<?php

use App\Services\FileService;

class FileServiceTest extends TestCase
{
    /**
     * @var App\Utilities\PatternUtility
     */
    protected static $patternUtility;

    /**
     * @var App\Services\FileService
     */
    protected static $fileService;

    protected static $firstPageData;

    protected static $secondPageData;

    protected static $brokenPageData;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$patternUtility = Mockery::mock(App\Utilities\PatternUtility::class);
        self::$patternUtility->shouldReceive('transformToRegex')
            ->andReturn('/page(\d+).json/')
            ->once();

        self::$fileService = new FileService(self::$patternUtility);

        self::$firstPageData = file_get_contents(getenv('TEST_DATA').'/page1.json', true);
        self::$secondPageData = file_get_contents(getenv('TEST_DATA').'/page2.json', true);
        self::$brokenPageData = file_get_contents(getenv('TEST_DATA').'/brokenPage1.json', true);
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$patternUtility = null;
        self::$fileService = null;

        self::$firstPageData = null;
        self::$secondPageData = null;
        self::$brokenPageData = null;
    }

    /**
     * @test
     * @dataProvider find_files_provider
     */
    public function will_find_files_correctly($provided, $expected): void
    {
        // Given
        Storage::shouldReceive('files')
            ->withAnyArgs()
            ->andReturn($provided)
            ->once();
        $fileService = self::$fileService;
        // When
        $result = $fileService->findFiles();
        // Then
        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function find_files_provider(): array
    {
        return [
            [
                ['.gitignore', 'page1.json', 'brokenPage2.json', 'brokenPage1.json', 'page2.json'],
                ['page1.json', 'page2.json']
            ],
            [
                ['.gitignore', 'paGe1.json', 'brokenPage2.json', 'brokenPage1.json', 'pAge2.json', 'strona1.json'],
                []
            ],
            [
                [],
                []
            ]
        ];
    }

    /** @test */
    public function will_read_single_file(): void
    {
        // Given
        Storage::shouldReceive('get')
            ->once()
            ->with('page1.json')
            ->andReturn(self::$firstPageData);
        $fileService = self::$fileService;
        // When
        $result = $fileService->getFilesContent(['page1.json']);
        // Then
        $this->assertEquals(
            [json_decode(self::$firstPageData)],
            $result
        );
    }

    /** @test */
    public function will_read_multiple_files(): void
    {
        // Given
        Storage::shouldReceive('get')
            ->with('page1.json')
            ->andReturn(self::$firstPageData)
            ->once();
        Storage::shouldReceive('get')
            ->with('page2.json')
            ->andReturn(self::$secondPageData)
            ->once();
        $fileService = self::$fileService;
        // When
        $result = $fileService->getFilesContent(['page1.json', 'page2.json']);
        // Then
        $this->assertEquals(
            [json_decode(self::$firstPageData), json_decode(self::$secondPageData)],
            $result
        );
    }

    /** @test */
    public function will_throw_exception_for_broken_data(): void
    {
        // Given
        Storage::shouldReceive('get')
            ->once()
            ->withAnyArgs()
            ->andReturn(self::$brokenPageData);
        $fileService = self::$fileService;
        // When
        $this->expectException(\JsonException::class);
        $result = $fileService->getFilesContent(['page1.json']);
    }
}
