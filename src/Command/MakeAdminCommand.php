<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\RoleService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:makeAdmin', description: 'Promotes user to be admin')]
class MakeAdminCommand extends Command
{
    public function __construct(private readonly RoleService $roleService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'Username');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = (string) $input->getArgument('username');
        $this->roleService->grantAdmin($username);

        return Command::SUCCESS;
    }
}