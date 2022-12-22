<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessage\CreateRequest;
use App\Http\Requests\ChatMessage\ReactMessageRequest;
use App\Models\User;
use App\Services\ChatMessage\IndexService;
use App\Services\ChatMessage\ReactMessageService;
use App\Services\ChatMessage\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{

    /**
     * List
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function index(int $id)
    {
        try {
            $result = resolve(IndexService::class)->handle($id);

            return response()->success($result);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }

    /**
     * Authenticate
     *
     * @param Request $request Request.
     *
     * @return JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $data = $request->validated();
        try {
            $result = resolve(StoreService::class)->handle($data);

            return response()->success($result);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }

    /**
     * React message
     *
     * @param Request $request Request.
     *
     * @return JsonResponse
     */
    public function react(ReactMessageRequest $request, int $id)
    {
        $data = $request->validated();
        try {
            $result = resolve(ReactMessageService::class)->handle($id, $data);

            return response()->success($result);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }
}
