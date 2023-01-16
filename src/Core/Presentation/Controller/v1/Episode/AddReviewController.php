<?php

namespace App\Core\Presentation\Controller\v1\Episode;

use App\Core\Presentation\Controller\AbstractController;
use App\Core\Presentation\Request\v1\Episode\AddReviewRequest;
use App\Core\UseCase\Web\Episode\AddReviewUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddReviewController extends AbstractController
{
    public function __construct(
        private readonly AddReviewUseCase $addReviewUseCase
    ) {
    }

    #[Route(
        '/api/v1/episode/{id}/review',
        name: 'v1_episode_review',
        methods: ['POST']
    )]
    public function __invoke(int $id, AddReviewRequest $request): Response
    {
        $this->addReviewUseCase->run($id, $request->getMessage());

        return $this->success();
    }
}
