<?php namespace TechExim\Lumen\Support\Testing;

use Illuminate\Http\Request;
use TechExim\Support\Testing\Crawler as BaseCrawler;

trait Crawler
{
    use BaseCrawler;

    /**
     * Call the given URI and return the Response.
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $parameters
     * @param  array  $cookies
     * @param  array  $files
     * @param  array  $server
     * @param  string $content
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $resources = $this->prepareRequest($method, $uri, $parameters, $cookies, $files, $server, $content);
        list($method, $uri, $parameters, $cookies, $files, $server, $content) = $resources;

        $this->currentUri = $this->prepareUrlForRequest($uri);

        $request = Request::create(
            $this->currentUri, $method, $parameters,
            $cookies, $files, $server, $content
        );

        $request = $this->beforeRequest($request);

        return $this->response = $this->afterRequest($this->app->prepareResponse($this->app->handle($request)));
    }
}