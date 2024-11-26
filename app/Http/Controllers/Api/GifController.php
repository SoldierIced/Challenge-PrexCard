<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gif;
use App\Models\GifUser;
use App\Services\GifService;
use Illuminate\Http\Request;

class GifController extends Controller
{
    protected $gifService;

    public function __construct(GifService $gifService)
    {
        $this->gifService = $gifService;
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
        ]);
        try {
            $gifs = $this->gifService->searchGifs(
                $validated['query'],
                $validated['limit'] ?? 10,
                $validated['offset'] ?? 0
            );
            return $this->sendResponse($gifs);
        } catch (\Throwable $e) {
            return $this->sendResponse(null, "an error has occurred", "error", $e, 422);
        }
    }

    public function getById(string $id)
    {
        try {
            $gif = $this->gifService->getGifById($id);
            return $this->sendResponse($gif, 'GIF found');
        } catch (\Throwable $e) {
            return $this->sendResponse(null, "an error has occurred", "error", $e, 422);
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'gif_id' => 'required',
        ]);

        try {
            $response = $this->gifService->getGifById($request->gif_id);
        } catch (\Throwable $e) {
            return $this->sendResponse(null, "Gif not found", "error", $e, 422);
        }
        try {
            $gif = Gif::updateOrCreate([
                "id" => $response["data"]["id"],
                "slug" => $response["data"]["slug"],
            ], [
                "id" => $response["data"]["id"],
                "url" => $response["data"]["url"],
                "slug" => $response["data"]["slug"],
                "embed_url" => $response["data"]["embed_url"],
                "username" => $response["data"]["username"],
                "source" => $response["data"]["source"],
                "title" => $response["data"]["title"],
                "source_tld" => $response["data"]["source_tld"],
                "alt_text" => $response["data"]["alt_text"],
            ]);

            GifUser::updateOrCreate([
                "user_id" => $request->user()->id,
                "gif_id" => $gif->id,
            ]);
            return $this->sendResponse($gif, 'GIF saved');
        } catch (\Throwable $e) {
            return $this->sendResponse(null, "an error has occurred", "error", $e, 500);
        }
    }
    public function delete(Request $request)
    {
        try {
            $request->validate([
                'gif_id' => 'required',
            ]);
            GifUser::where([
                "user_id" => $request->user()->id,
                "gif_id" => $request->gif_id,
            ])->delete();
            return $this->sendResponse(null, 'GIF deleted');
        } catch (\Throwable $e) {
            return $this->sendResponse(null, "an error has occurred", "error", $e, 500);
        }
    }
}
