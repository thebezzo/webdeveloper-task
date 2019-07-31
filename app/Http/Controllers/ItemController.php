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

    public function showPage(int $id)
    {
        try {
            $data = $this->itemService->getPage($id);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\JsonException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Please contact administrator'], 500);
        }
        return [
            'data' => $data,
            'next_page' => $this->itemService->getNextPage(),
            'total' => $this->itemService->checkPagesCount()
        ];
    }
}
