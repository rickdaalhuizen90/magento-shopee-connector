<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePKCEPair extends Command
{
    protected function configure(): void
    {
        $this->setName('shopee:generate:pkce');
        $this->setDescription('Generate PKCE pair');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = [
                'state' => '',
                'code_verifier' => '',
                'code_challenge' => '',
                'full_url' => '',
            ];

            $output->writeln('<info>' . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</info>');
        } catch (LocalizedException $localizedException) {
            $output->writeln(sprintf(
                '<error>%s</error>',
                $localizedException->getMessage()
            ));
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
