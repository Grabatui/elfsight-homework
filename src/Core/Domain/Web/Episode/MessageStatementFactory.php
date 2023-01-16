<?php

namespace App\Core\Domain\Web\Episode;

readonly class MessageStatementFactory
{
    public function __construct(
        private GetRawSentimentForMessageInterface $getRawSentimentForMessage
    ) {
    }

    /**
     * @description From 0 to 1
     * @param string $message
     * @return float
     */
    public function make(string $message): float
    {
        $rawStatement = $this->getRawSentimentForMessage->get($message);

        $percentFromTheHalf = min(((abs($rawStatement) * 100) * 50) / 100, 100);

        $resultPercent = $rawStatement > 0.0
            ? (50 + $percentFromTheHalf)
            : (50 - $percentFromTheHalf);

        return round($resultPercent / 100, 2);
    }
}
