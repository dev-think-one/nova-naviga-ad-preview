<?php

namespace NovaNavigaAdPreview\Tests;

use Illuminate\Support\Facades\Http;

class ListRequestTest extends TestCase
{
    /** @test */
    public function success_call_endpoint()
    {
        Http::fake(function (\Illuminate\Http\Client\Request $request) {
            $this->assertStringStartsWith('Basic ', $request->header('Authorization')[0]);
            $this->assertEquals('test.request', $request->header('Host')[0]);

            $url = parse_url($request->url());

            $this->assertEquals('/my-endpoint', $url['path']);
            $this->assertEquals('foo=bar&baz=qux&page=1&pageSize=2', $url['query']);

            return Http::response(json_encode([
                'Results' => [
                    [
                        'id' => 22,
                    ],
                    [
                        'id' => 333,
                    ],
                ],
                'PageNumber'           => 2,
                'PageSize'             => 3,
                'TotalNumberOfPages'   => 4,
                'TotalNumberOfRecords' => 5,
            ]), 200);
        });

        $response = $this->postJson(route('nova-naviga-ad-preview.api.list'), [
            'endpoint' => 'my-endpoint',
            'query'    => "foo:bar\nbaz:qux",
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'meta' => [
                'currentPage',
                'totalPages',
                'countEntities',
                'totalEntities',
            ],
        ]);

        $response->assertJsonPath('meta.currentPage', 2);
        $response->assertJsonPath('meta.totalPages', 4);
        $response->assertJsonPath('meta.countEntities', 3);
        $response->assertJsonPath('meta.totalEntities', 5);

        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.1.id', 333);
    }
}
