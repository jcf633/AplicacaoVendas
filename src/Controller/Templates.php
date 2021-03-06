<?php

namespace App\Controller;

use App\Services\EmailEmpresa\EmailEmpresaService;
use App\Services\Vendedor\VendedorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Templates extends AbstractController
{
    private $entityManager;

    public function __construct (EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function home()
    {
        $emailEmpresaService = new EmailEmpresaService($this->entityManager);
        $emailEmpresa = $emailEmpresaService->buscarEmailAtualEmoresa();

        return $this->render('/Menu/menu.html.twig', ["email" => $emailEmpresa]);
    }

    /**
     * @Route("/cadastrar/vendedor", methods={"GET"})
     */
    public function cadastrarVendedor()
    {
        return $this->render('/Vendedor/cadastrar_vendedor.html.twig');
    }

    /**
     * @Route("/cadastrar/venda", methods={"GET"})
     */
    public function cadastrarVenda()
    {
        $vendedorService = new VendedorService($this->entityManager);
        $vendedores = $vendedorService->buscarVendedoresCadastroVenda();

        return $this->render('/Venda/cadastrar_venda.html.twig', ["vendedores" => $vendedores]);
    }


    /**
     * @Route("/listar/vendedores", methods={"GET"})
     */
    public function listarVendedores()
    {
        $vendedorService = new VendedorService($this->entityManager);
        $vendedores = $vendedorService->buscarVendedores();

        return $this->render('/Vendedor/listar_vendedores.html.twig', ["vendedores" => $vendedores]);
    }

    /**
     * @Route("/listar/vendas/vendedores/{id_vendedor}", methods={"GET"})
     */
    public function listarVendasVendedor(int $id_vendedor)
    {
        $vendedorService = new VendedorService($this->entityManager);
        $vendedores = $vendedorService->buscarVendasVendedor($id_vendedor);

        return $this->render('/Vendedor/listar_vendas_vendedor.html.twig', ["vendedor" => $vendedores]);
    }
}