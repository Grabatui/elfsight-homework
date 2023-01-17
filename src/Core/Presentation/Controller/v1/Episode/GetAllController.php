<?php

namespace App\Core\Presentation\Controller\v1\Episode;

use App\Core\Domain\Web\Episode\Entity\Episode;
use App\Core\Presentation\Controller\AbstractController;
use App\Core\Presentation\Formatter\Episode\EpisodeFormatter;
use App\Core\Presentation\Request\v1\Episode\GetAllRequest;
use App\Core\UseCase\Web\Episode\GetAllUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GetAllController extends AbstractController
{
    public function __construct(
        private readonly GetAllUseCase $getAllUseCase,
        private readonly EpisodeFormatter $episodeFormatter
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

        $page ??= 1;

        return $this->success([
            'items' => array_map(
                fn (Episode $episode): array => $this->episodeFormatter->format($episode),
                $result->getEpisodes()
            ),
            'nextPage' => $result->isNextExists() ? $this->makePageUrl($page + 1) : null,
            'prevPage' => $result->isPrevExists() ? $this->makePageUrl($page - 1) : null,
        ]);
    }

    private function makePageUrl(int $page): string
    {
        return $this->generateUrl('v1_episode_all', compact('page'), UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
