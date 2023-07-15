<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produits')]
class ProductController extends AbstractController
{
    #[Route('', name: 'app_product')]
    public function index(ProductRepository $productRepo, CategoryRepository $categRepo): Response
    {
        // Récupérer tous les produits
        $products = $productRepo->findAll();

        // Récupérer toutes les catégories
        $categories = $categRepo->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    #[Route('/detail/{id}', name: 'detail')]
    public function details(ProductRepository $repo, $id): Response
    {
        $product = $repo->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
