<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;

class ItemController extends Controller
{
    /**
     * @var App\Services\ItemService
     */
    private $itemService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function showFirstPage()
    {
        return [
            'data' => $this->itemService->getPage(1),
            'next_page' => $this->itemService->getNextPage(),
            'total' => $this->itemService->checkPagesCount()
        ];
    }

    public function showPage(int $id)
    {
        return [
            'data' => $this->itemService->getPage($id),
            'next_page' => $this->itemService->getNextPage(),
            'total' => $this->itemService->checkPagesCount()
        ];
    }
}
