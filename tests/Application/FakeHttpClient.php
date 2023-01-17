<?php

namespace App\Tests\Application;

use RuntimeException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final readonly class FakeHttpClient implements HttpClientInterface
{
    /**
     * @param MockResponse[] $responses
     */
    public function __construct(
        private array $responses
    ) {
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $response = $this->responses[$url] ?? null;

        if (null === $response) {
            throw new RuntimeException(sprintf('There is no response for url: %s', $url));
        }

        return (new MockHttpClient($response, 'https://fake.fake'))->request($method, $url);
    }

    public function stream(iterable|ResponseInterface $responses, float $timeout = null): ResponseStreamInterface
    {
        throw new RuntimeException(sprintf('%s() is not implemented', __METHOD__));
    }

    public function withOptions(array $options): static
    {
        return $this;
    }
}
