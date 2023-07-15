<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductRepository $repo): Response
    {
        $cart = $session->get('cart', []);
        $data = [];

        $totalAmount = 0;
        foreach ($cart as $id => $quantity) {
            $product = $repo->find($id);
            $data[] = [
                'product' => $product,
                'quantity' => $quantity,
                // 'totalProduct' => $product->getPrice() * $quantity
            ];

            $totalAmount += $product->getPrice() * $quantity;
        }

        return $this->render('cart/index.html.twig', compact('data', 'totalAmount'));
    }


    #[Route('/add/{id}', name: 'add')]
    public function add(Product $product, SessionInterface $session): Response
    {
        $productId = $product->getId();
        $cart = $session->get('cart', []);

        empty($cart[$productId]) ? $cart[$productId] = 1 : $cart[$productId]++;

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/reduce/{id}', name: 'reduce')]
    public function remove(Product $product, SessionInterface $session): Response
    {
        $productId = $product->getId();
        $cart = $session->get('cart', []);

        if (!empty($cart[$productId])) {
            if ($cart[$productId] > 1) {
                $cart[$productId]--;
            } else {
                unset($cart[$productId]);
            }
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Product $product, SessionInterface $session): Response
    {
        $productId = $product->getId();
        $cart = $session->get('cart', []);

        if (!empty($cart[$productId])) {
            unset($cart[$productId]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/clearCart', name: 'clearCart')]
    public function clearCart(SessionInterface $session): Response
    {
        $session->remove('cart');

        return $this->redirectToRoute('cart_index');
    }

    // #[Route("/add/{id}", name: 'app_cart_add')]
    // public function addProductToCart($id, EntityManagerInterface $manager): Response
    // {
    //     $product = $manager->getRepository(Product::class)->find($id);

    //     $user = $this->getUser();

    //     // Recherche du panier de l'utilisateur
    //     $cart = $manager->getRepository(Cart::class)->findOneBy([
    //         'user' => $user,

    //     ]);

    //     // Si le panier n'existe pas pour cet utilisateur, le créer
    //     if (!$cart) {
    //         $cart = new Cart();
    //         $cart->setUser($user);
    //         $cart->setCreatedAt(new \DateTimeImmutable());
    //         $manager->persist($cart);
    //     }
    //     // Ajout du produit au panier
    //     $cart->addProduct($product);

    //     // Mise à jour de la qté+1 produit au panier
    //     $quantityProductInCart = $cart->getProductQuantity($product);
    //     $quantityProductInCart++;
    //     $cart->setProductQuantity($quantityProductInCart);
    //     //gros probleme avec la quantité du produit
    //     //probleme de jointure?


    //     // Calcul du total du produit au panier(qte_produit x prix_produit)
    //     $productPrice = $product->getPrice();
    //     $totalProductPrice = $productPrice * $quantityProductInCart;

    //     $cart->setTotalProductPrice($totalProductPrice);

    //     $manager->flush();

    //     // Redirection vers une page de confirmation ou de visualisation du panier
    //     return $this->redirectToRoute('app_cart', [
    //         'cart' => $cart,
    //     ]);
    // }


    // #[Route("/mon panier", name: 'app_cart_show')]
    // public function cartShow(EntityManagerInterface $manager): Response
    // {
    //     $user = $this->getUser();

    //     // Recherche du panier de l'utilisateur
    //     $cart = $manager->getRepository(Cart::class)->findOneBy([
    //         'user' => $user,

    //     ]);

    //     dd($cart);


    //     // Si le panier n'existe pas pour cet utilisateur
    //     if (!$cart) {
    //         return $this->redirectToRoute('cart/index.html.twig', [
    //             'emptyCartMsg' => 'Votre panier est vide',
    //         ]);
    //     }








    //     // Redirection vers une page de confirmation ou de visualisation du panier
    //     return $this->render('cart/index.html.twig', [
    //         'products' => $products,
    //     ]);
    // }
}
