<?php

namespace App\Cart;

use Symfony\Component\HttpFoundation\RequestStack;

class SessionCart implements CartInterface
{
    private const CART_KEY = 'cart';

    public function __construct(private RequestStack $requestStack)
    {
    }

    public function add(int $productId, int $quantity): void
    {
        $cart = $this->getItems();
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        $this->requestStack->getSession()->set(self::CART_KEY, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->getItems();
        unset($cart[$productId]);
        $this->requestStack->getSession()->set(self::CART_KEY, $cart);
    }

    public function getItems(): array
    {
        return $this->requestStack->getSession()->get(self::CART_KEY, []);
    }

    public function clear(): void
    {
        $this->requestStack->getSession()->remove(self::CART_KEY);
    }
}