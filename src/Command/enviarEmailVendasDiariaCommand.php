<?php

namespace App\Command;

use App\Services\Venda\VendaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;

class enviarEmailVendasDiariaCommand extends Command
{
    private $entityManager;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;

        parent::__construct(null);
    }

    protected function configure()
    {
        $this->setName('email:enviar-relatorio-vendas-diaria');
        $this->setDescription('Enviar email com relatório de vendas diaria');
        $this->setHelp('Comando para enviar email com relatório de vendas efetuadas no dia');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $vendaService = new VendaService($this->entityManager, $this->mailer);
        $vendaService->enviarEmailRelatorioVendas();

        $output->writeln('Email enviado com sucesso !!!');

        return Command::SUCCESS;
    }
}