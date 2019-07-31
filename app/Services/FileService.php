<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Utilities\PatternUtility;

class FileService
{
    /**
     * @var App\Utilities\PatternUtility
     */
    private $patternUtility;

    /**
     * @var string
     */
    private $fileNameRegex;

    public function __construct(PatternUtility $patternUtility)
    {
        $this->patternUtility = $patternUtility;
        $this->fileNameRegex = $this->patternUtility->transformToRegex();
    }

    public function findFiles(?string $path = null): array
    {
        $fsFiles = $this->getFiles($path);
        $files = array_filter(
            $fsFiles,
            function ($item) {
                return preg_match($this->fileNameRegex, $item, $matches, PREG_OFFSET_CAPTURE, 0);
            }
        );
        return array_values($files);
    }

    public function getFilesContent(array $files): array
    {
        $fileContentList = [];
        $i = 0;
        foreach ($files as $file) {
            $fileContentList[$i] = json_decode(Storage::get($file), FALSE, 512, JSON_THROW_ON_ERROR);
            $i++;
        }
        return $fileContentList;
    }

    private function getFiles(?string $path = null): array
    {
        return Storage::files($path);
    }
}
