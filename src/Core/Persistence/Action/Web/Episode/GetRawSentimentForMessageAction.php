<?php

namespace App\Core\Persistence\Action\Web\Episode;

use App\Core\Domain\Web\Episode\GetRawSentimentForMessageInterface;
use Sentiment\Analyzer;

readonly class GetRawSentimentForMessageAction implements GetRawSentimentForMessageInterface
{
    public function __construct(
        private Analyzer $analyzer
    ) {
    }

    public function get(string $message): float
    {
        $result = $this->analyzer->getSentiment($message);

        return $result['compound'] ?? 0.0;
    }
}
