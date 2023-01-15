<?php

namespace App\Core\Presentation\Controller\v1\Episode;

use App\Core\Domain\Web\Episode\Entity\Episode;
use App\Core\Presentation\Controller\AbstractController;
use App\Core\Presentation\Request\v1\Episode\GetAllRequest;
use App\Core\UseCase\Web\Episode\GetAllUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GetAllController extends AbstractController
{
    private const RELEASE_DATE_FORMAT = 'Y-m-d';

    public function __construct(
        private readonly GetAllUseCase $getAllUseCase
    ) {
    }

    #[Route(
        '/api/v1/episode',
        name: 'v1_episode_all'
    )]
    public function __invoke(GetAllRequest $request): Response
    {
        $page = $request->getPage();

        $result = $this->getAllUseCase->get($page);

        return $this->success([
            'items' => array_map(
                fn (Episode $episode): array => $this->processEpisode($episode),
                $result->getEpisodes()
            ),
            'nextPage' => $result->isNextExists() ? $this->makePageUrl($page + 1) : null,
            'prevPage' => $result->isPrevExists() ? $this->makePageUrl($page - 1) : null,
        ]);
    }

    private function processEpisode(Episode $episode): array
    {
        return [
            'id' => $episode->getId(),
            'name' => $episode->getName(),
            'release_date' => $episode->getReleaseDatetime()->format(static::RELEASE_DATE_FORMAT),
        ];
    }

    private function makePageUrl(int $page): string
    {
        return $this->generateUrl('v1_episode_all', compact('page'), UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
