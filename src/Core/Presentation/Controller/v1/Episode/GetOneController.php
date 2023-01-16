<?php

namespace App\Core\Presentation\Controller\v1\Episode;

use App\Core\Presentation\Controller\AbstractController;
use App\Core\Presentation\Formatter\Episode\EpisodeFormatter;
use App\Core\UseCase\Web\Episode\GetOneUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetOneController extends AbstractController
{
    public function __construct(
        private readonly GetOneUseCase $getOneUseCase,
        private readonly EpisodeFormatter $episodeFormatter
    ) {
    }

    #[Route(
        '/api/v1/episode/{id}',
        name: 'v1_episode_one'
    )]
    public function __invoke(int $id): Response
    {
        $entity = $this->getOneUseCase->get($id);

        return $this->success(
            $this->episodeFormatter->formatWithSentimentAndReviews($entity)
        );
    }
}
