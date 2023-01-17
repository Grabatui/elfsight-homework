<?php

namespace App\Tests\Application\Core\Presentation\Controller\v1\Episode;

use App\Tests\Application\BaseTestCase;
use DateTimeImmutable;
use DateTimeInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetAllControllerTest extends BaseTestCase
{
    /**
     * @throws JWTEncodeFailureException
     */
    public function testHappyPath(): void
    {
        $this->createUser('testUser', 'testPassword');
        $this->login('testUser', 'testPassword');

        $this->addFakeResponses([
            '/api/episode' => new MockResponse(
                json_encode($this->makeResponseStub(1, 2, true))
            ),
        ]);

        $this->client->xmlHttpRequest('GET', '/api/v1/episode');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(
            $this->client->getResponse()->getContent(),
            json_encode([
                'data' => [
                    'items' => [
                        [
                            'id' => 1,
                            'name' => 'Episode 1',
                            'release_date' => '1970-01-01',
                        ],
                        [
                            'id' => 2,
                            'name' => 'Episode 2',
                            'release_date' => '1970-01-02',
                        ],
                    ],
                    'nextPage' => 'http://localhost/api/v1/episode?page=2',
                    'prevPage' => null,
                ],
                'type' => 'success',
            ])
        );
    }

    private function makeResponseStub(
        int $currentPage = 1,
        int $episodesCount = 2,
        bool $isNextExists = false,
        bool $isPrevExists = false
    ): array {
        $results = [];
        for ($i = 0; $i < $episodesCount; $i++) {
            $episodeNumber = $i + 1;

            $results[] = [
                'id' => $episodeNumber,
                'name' => 'Episode ' . $episodeNumber,
                'air_date' => sprintf('January %d, 1970', $episodeNumber),
                'episode' => 'S01E' . str_pad($episodeNumber, 2, '0', STR_PAD_LEFT),
                'characters' => [],
                'url' => '',
                'created' => (new DateTimeImmutable())->format(DateTimeInterface::ATOM),
            ];
        }

        return [
            'info' => [
                'count' => 50,
                'pages' => $isNextExists || $isPrevExists ? 3 : 1,
                'next' => $isNextExists ? 'https://rickandmortyapi.com/api/episode?page=' . ($currentPage + 1) : null,
                'prev' => $isPrevExists ? 'https://rickandmortyapi.com/api/episode?page=' . ($currentPage - 1) : null,
            ],
            'results' => $results,
        ];
    }
}
