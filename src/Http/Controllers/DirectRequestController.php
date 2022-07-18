<?php

namespace NovaNavigaAdPreview\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use NavigaAdClient\NavigaAd;
use NavigaAdClient\Responses\PaginatedResponse;

class DirectRequestController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'endpoint' => ['required', 'string'],
            'query'    => ['nullable', 'string'],
        ]);

        $endpoint  = $request->input('endpoint');
        $query     = array_filter(array_map('trim', explode(PHP_EOL, $request->input('query', ''))));
        $queryData = [];
        foreach ($query as $line) {
            $key   = Str::before($line, ':');
            $value = Str::after($line, ':');
            if ($key && $value) {
                $queryData[$key] = $value;
            }
        }

        /** @var PaginatedResponse $response */
        $response = NavigaAd::pendingRequest()->get($endpoint, $queryData);

        return Response::json([
            'data' => $response->json(),
        ]);
    }
}
