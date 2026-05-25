<?php

namespace App\Controller;

use App\Cart\CartHandler;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_details')]
    public function details(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        return $this->render('main/product_details.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/cart', name: 'app_cart')]
    public function cart(CartHandler $cartHandler, ProductRepository $productRepository): Response
    {
        $items = $cartHandler->getItems();
        $cartProducts = [];

        foreach ($items as $productId => $quantity) {
            $product = $productRepository->find($productId);
            if ($product) {
                $cartProducts[] = [
                    'product'  => $product,
                    'quantity' => $quantity,
                    'total'    => $product->getSellPrice() * $quantity,
                ];
            }
        }

        $grandTotal = array_sum(array_column($cartProducts, 'total'));

        return $this->render('main/cart.html.twig', [
            'cartProducts' => $cartProducts,
            'grandTotal'   => $grandTotal,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function addToCart(int $id, CartHandler $cartHandler): Response
    {
        $cartHandler->add($id, 1);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function removeFromCart(int $id, CartHandler $cartHandler): Response
    {
        $cartHandler->remove($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/categories', name: 'app_categories')]
    public function categories(CategoryRepository $categoryRepository): Response
    {
        return $this->render('main/browse_categories.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('main/profile.html.twig');
    }

    #[Route('/products/category/{id}', name: 'app_products_by_category')]
    public function productsByCategory(int $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        return $this->render('main/products_by_category.html.twig', [
            'category' => $category,
        ]);
    }
}