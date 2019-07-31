<?php

use App\Services\ItemService;
use App\Services\FileService;

class ItemsServiceTest extends TestCase
{
    /**
     * @var App\Services\FileService
     */
    protected $fileService;

    protected static $firstPageData;

    protected static $secondPageData;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$firstPageData = json_decode(file_get_contents(getenv('TEST_DATA').'/page1.json', true), FALSE);
        self::$secondPageData = json_decode(file_get_contents(getenv('TEST_DATA').'/page2.json', true), FALSE);
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$firstPageData = null;
        self::$secondPageData = null;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->fileService = Mockery::mock(FileService::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->fileService = null;
    }

    /** @test */
    public function will_obtain_page_data(): void
    {
        // Given
        $this->fileService->shouldReceive('findFiles')
            ->andReturn(['page1.json']);
        $this->fileService->shouldReceive('getFilesContent')
            ->andReturn([self::$firstPageData])
            ->once();
        $itemService = new ItemService($this->fileService);
        // When
        $result = $itemService->getPage(1);
        // Then
        $this->assertEquals(
            self::$firstPageData,
            $result
        );
    }

    /**
     * @test
     * @dataProvider pointer_expectation_provider
     */
    public function will_calculate_pointer_correctly($provided, $pointer, $expected): void
    {
        // Given
        $this->fileService->shouldReceive('findFiles')
            ->andReturn($provided);
        $this->fileService->shouldReceive('getFilesContent')
            ->withAnyArgs()
            ->andReturn([self::$firstPageData]);
        $itemService = new ItemService($this->fileService);
        // When
        $itemService->getPage($pointer);
        $result = $itemService->getNextPage();
        // Then
        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function pointer_expectation_provider(): array
    {
        return [
            [['page1.json', 'page2.json'], 1, 2],
            [['page1.json', 'page2.json'], 2, -1],
            [['page1.json'], 1, -1],
        ];
    }

    /**
     * @test
     * @dataProvider pages_count_provider
     */
    public function will_count_pages_correctly($provided, $expected): void
    {
        // Given
        $this->fileService->shouldReceive('findFiles')
            ->andReturn($provided);
        $itemService = new ItemService($this->fileService);
        // When
        $result = $itemService->checkPagesCount();
        // Then
        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function pages_count_provider(): array
    {
        return [
            [['page1.json', 'page2.json'], 2],
            [['page1.json', 'page2.json', 'page3.json'], 3],
            [['page1.json'], 1],
        ];
    }
}
