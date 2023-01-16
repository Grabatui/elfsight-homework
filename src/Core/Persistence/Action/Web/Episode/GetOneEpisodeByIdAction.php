<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Common\Exception\OutputException;
use App\Core\Domain\Web\Episode\Entity\Episode;
use App\Core\Domain\Web\Episode\GetOneEpisodeByIdInterface;
use App\Core\Persistence\Model\Web\Episode\EpisodeModel;
use App\Core\Persistence\Repository\ApiRickAndMorty\RickAndMortyApiRepository;

readonly class GetOneEpisodeByIdAction implements GetOneEpisodeByIdInterface
{
    public function __construct(
        private RickAndMortyApiRepository $rickAndMortyApiRepository,
        private EpisodeModel $episodeModel
    ) {
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): Episode
    {
        $entity = $this->rickAndMortyApiRepository->getOneEpisode($id);

        if (!$entity) {
            throw OutputException::makeAsNotFound('Episode not found');
        }

        return $this->episodeModel->fromRepositoryToDomain($entity);
    }
}
