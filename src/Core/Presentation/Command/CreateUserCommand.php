<?php

namespace App\Core\Presentation\Command;

use App\Core\Presentation\Provider\User\UserProvider;
use App\Core\UseCase\Cli\User\CreateUserUseCase;
use InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates users and stores them in the database'
)]
class CreateUserCommand extends Command
{
    private const USERNAME_PATTERN = '#^[a-zA-Z0-9_]+$#';
    private const MIN_PASSWORD_LENGTH = 6;

    public function __construct(
        private readonly CreateUserUseCase $createUserUseCase,
        private readonly UserProvider $userProvider
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::OPTIONAL, 'The username of the new user')
            ->addArgument('password', InputArgument::OPTIONAL, 'The plain password of the new user')

            ->addOption('admin', null, InputOption::VALUE_NONE, 'If set, the user is created as an administrator');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $plainPassword = $input->getArgument('password');
        $isAdmin = $input->getOption('admin');

        $this->validateParameters($username, $plainPassword);

        $this->createUserUseCase->run($username, $plainPassword, $isAdmin);

        $output->writeln('User is successfully created');

        return Command::SUCCESS;
    }

    private function validateParameters(?string $username, ?string $plainPassword): void
    {
        if (!$username || preg_match(static::USERNAME_PATTERN, $username) !== 1) {
            throw new InvalidArgumentException(
                sprintf('Username is required and mast be valid by mask: %s', static::USERNAME_PATTERN)
            );
        }

        if (!$plainPassword || mb_strlen($plainPassword) < static::MIN_PASSWORD_LENGTH) {
            throw new InvalidArgumentException('Password is required and must be at least 6 characters long');
        }

        // Спорно, конечно, что, может, это является частью бизнес-логики и тогда нужно переместить проверку в useCase
        if ($this->userProvider->isUserExistsByUsername($username)) {
            throw new InvalidArgumentException(
                sprintf('User with username "%s" already exists', $username)
            );
        }
    }
}