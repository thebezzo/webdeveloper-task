<?php

namespace App\Services;

class ItemService
{
    /**
     * @var App\Services\FileService
     */
    private $fileService;

    /**
     * @var array
     */
    private $fileList;

    /**
     * @var int
     */
    private $pointer;

    /**
     * @var int
     */
    private $nextPointer;

    /**
     * @var int
     */
    private $maxPointer;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->populate();
    }

    public function getPage(int $index)
    {
        if ($index > $this->maxPointer) {
            throw new \InvalidArgumentException('Not found', 404);
        }
        $this->pointer = $index <= 0 ? 1 : $index;
        $this->next();
        return $this->fileService->getFilesContent([$this->fileList[$this->pointer-1]])[0];
    }

    public function getNextPage()
    {
        return $this->nextPointer;
    }

    public function checkPagesCount()
    {
        return $this->maxPointer;
    }

    private function next(): void
    {
        $this->nextPointer = $this->pointer+1;
        if (!$this->hasNext()) {
            $this->nextPointer = -1;
        }
    }

    private function hasNext(): bool
    {
        if ($this->nextPointer > $this->maxPointer) {
            return false;
        }
        return true;
    }

    private function populate(): void
    {
        $this->fileList = $this->fileService->findFiles();
        $this->pointer = 1;
        $this->maxPointer = count($this->fileList);
    }
}
