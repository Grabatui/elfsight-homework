<?php

namespace App\Tests\Application;

use App\Core\UseCase\Cli\User\CreateUserUseCase;
use Exception;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
{
    use RefreshDatabaseTrait;

    protected KernelBrowser $client;

    private ?CreateUserUseCase $createUserUseCase = null;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->createUserUseCase = $this->getContainer()->get(CreateUserUseCase::class);
    }

    protected function createUser(string $username, string $password, bool $isAdmin = false): void
    {
        if (!$this->createUserUseCase) {
            throw new RuntimeException('CreateUserUseCase is not defined');
        }

        $this->createUserUseCase->run($username, $password, $isAdmin);
    }

    /**
     * @throws JWTEncodeFailureException
     */
    protected function login(string $username, string $password): void
    {
        /** @var JWTEncoderInterface $encoder */
        $encoder = $this->client->getContainer()->get(JWTEncoderInterface::class);

        $this->client->setServerParameter(
            'HTTP_AUTHORIZATION',
            sprintf('Bearer %s', $encoder->encode(['username' => $username, 'password' => $password]))
        );
    }

    protected function addFakeResponses(array $responses): void
    {
        static::getContainer()->set(
            'fake_http_client',
            new FakeHttpClient($responses)
        );
    }
}
