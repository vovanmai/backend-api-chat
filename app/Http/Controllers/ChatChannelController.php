<?php

namespace App\Http\Controllers;

use App\Services\ChatChannel\DetailService;
use App\Services\ChatChannel\IndexService;
use App\Services\ChatChannel\ReadChannelService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ChatChannelController extends Controller
{
    /**
     * List
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $result = resolve(IndexService::class)->handle();

            return response()->success($result);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }

    /**
     * Show
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $result = resolve(DetailService::class)->handle($id);

            return response()->success($result);
        } catch (ModelNotFoundException $exception) {
            response()->notFound($exception);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }

    /**
     * Read channel
     *
     * @return JsonResponse
     */
    public function read(int $id)
    {
        try {
            $result = resolve(ReadChannelService::class)->handle($id);

            return response()->success($result);
        } catch (ModelNotFoundException $exception) {
            response()->notFound($exception);
        } catch (Exception $exception) {
            return response()->error($exception);
        }
    }
}
