<?php

namespace App\Tests\Application\Core\Presentation\Controller\v1\Episode;

use App\Core\Persistence\Entity\ApiRickAndMorty\EpisodesResult as RepositoryEpisodesResult;
use App\Tests\Application\FakeHttpClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetAllControllerTest extends WebTestCase
{
    public function testHappyPath(): void
    {
        $client = self::createClient();

        $returnEpisodesResult = new RepositoryEpisodesResult([], false, false); // TODO
        $client->request(
            'POST',
            '/api/v1/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'user',
                'password' => 'password',
            ])
        );
dd($client->getResponse()->getContent());
        $this->getContainer()->set(
            FakeHttpClient::class,
            new FakeHttpClient([
                '/api/episode' => new MockResponse(json_encode([])),
            ])
        );

        $client->xmlHttpRequest('GET', '/api/v1/episode');

        // TODO
        dd($client->getResponse()->getContent());
    }
}
