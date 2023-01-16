<?php

namespace App\Core\Persistence\Repository\ApiRickAndMorty;

use App\Core\Persistence\Entity\ApiRickAndMorty\EpisodeEntity;
use App\Core\Persistence\Entity\ApiRickAndMorty\EpisodesResult;
use DateTimeImmutable;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class RickAndMortyApiRepository
{
    private const AIR_DATE_FORMAT = 'F j, Y';

    private HttpClientInterface $httpClient;

    public function __construct(
        string $baseUri
    ) {
        $this->httpClient = $this->buildClient($baseUri);
    }

    public function getAllEpisodes(?int $page = null): EpisodesResult
    {
        try {
            $uri = '/api/episode';

            $query = [];
            if ($page) {
                $query['page'] = $page;
            }

            if (!empty($query)) {
                $uri .= sprintf('?%s', http_build_query($query));
            }

            $result = $this->httpClient->request('GET', $uri)->toArray();

            return new EpisodesResult(
                array_map(
                    fn (array $raw): EpisodeEntity => $this->makeEpisode($raw),
                    $result['results'] ?? []
                ),
                !empty($result['info']['next']),
                !empty($result['info']['prev'])
            );
        } catch (Throwable) {
            return new EpisodesResult([], false, false);
        }
    }

    public function getOneEpisode(int $id): ?EpisodeEntity
    {
        try {
            $result = $this->httpClient
                ->request('GET', sprintf('/api/episode/%d', $id))
                ->toArray();

            return $this->makeEpisode($result);
        } catch (Throwable) {
            return null;
        }
    }

    private function buildClient(string $baseUri): HttpClientInterface
    {
        return HttpClient::createForBaseUri($baseUri);
    }

    private function makeEpisode(array $raw): EpisodeEntity
    {
        return new EpisodeEntity(
            $raw['id'],
            $raw['name'],
            DateTimeImmutable::createFromFormat(static::AIR_DATE_FORMAT, $raw['air_date'])
        );
    }
}
