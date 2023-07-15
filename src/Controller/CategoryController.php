<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/category', name: 'categories_')]
class CategoryController extends AbstractController
{
    #[Route('/all', name: 'all')]
    public function index(CategoryRepository $CatRepo,): Response
    {

        $categories = $CatRepo->findAll();
        return $this->render('partials/header.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{id}', name: 'list')]
    public function list(Category $category): Response
    {
        $products = $category->getProducts();


        return $this->render(
            'category/index.html.twig',
            compact('category', 'products')
        );
    }
}
