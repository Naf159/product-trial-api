<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllProducts(): array
    {
        return $this->entityManager->getRepository(Product::class)->findAll();
    }

    public function getProductById(int $id): ?Product
    {
        return $this->entityManager->getRepository(Product::class)->find($id);
    }

    public function createProduct(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function updateProduct(Product $product): void
    {
        $this->entityManager->flush();
    }

    public function deleteProduct(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}