<?php

namespace App\Tests\Unit\Core\Domain\Web\Episode;

use App\Core\Domain\Web\Episode\GetRawSentimentForMessageInterface;
use App\Core\Domain\Web\Episode\MessageStatementFactory;
use PHPUnit\Framework\TestCase;

class MessageStatementFactoryTest extends TestCase
{
    private const DEFAULT_MESSAGE = 'defaultMessage';

    public function testNegative(): void
    {
        $this->processSentimentChecks([
            [-1.0, 0.0],
            [-0.5, 0.25],
        ]);
    }

    public function testNeutral(): void
    {
        $this->processSentimentChecks([
            [0.0, 0.5],
        ]);
    }

    public function testPositive(): void
    {
        $this->processSentimentChecks([
            [0.5, 0.75],
            [1.0, 1.0],
        ]);
    }

    private function makeGetRawSentimentForMessage(
        float $returnValue
    ): GetRawSentimentForMessageInterface {
        $mock = $this->createMock(GetRawSentimentForMessageInterface::class);
        $mock->method('get')->with(static::DEFAULT_MESSAGE)->willReturn($returnValue);

        return $mock;
    }

    private function processSentimentChecks(array $sentimentChecks): void
    {
        foreach ($sentimentChecks as $sentimentRanks) {
            [$rawSentimentRank, $resultSentimentRank] = $sentimentRanks;

            $factory = new MessageStatementFactory(
                $this->makeGetRawSentimentForMessage($rawSentimentRank)
            );

            $this->assertEquals(
                $factory->make(static::DEFAULT_MESSAGE),
                $resultSentimentRank
            );
        }
    }
}
