<?php

namespace NovaNavigaAdPreview\Tests;

use Illuminate\Support\Facades\Http;

class DirectRequestTest extends TestCase
{
    /** @test */
    public function success_call_endpoint()
    {
        Http::fake(function (\Illuminate\Http\Client\Request $request) {
            $this->assertStringStartsWith('Basic ', $request->header('Authorization')[0]);
            $this->assertEquals('test.request', $request->header('Host')[0]);

            $url = parse_url($request->url());

            $this->assertEquals('/my-endpoint', $url['path']);
            $this->assertEquals('foo=bar&baz=qux', $url['query']);

            return Http::response(json_encode([
                'responseFoo' => 'quex',
            ]), 200);
        });

        $response = $this->postJson(route('nova-naviga-ad-preview.api.direct'), [
            'endpoint' => 'my-endpoint',
            'query'    => "foo:bar\nbaz:qux",
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
        ]);
        $response->assertJsonPath('data.responseFoo', 'quex');
    }
}
