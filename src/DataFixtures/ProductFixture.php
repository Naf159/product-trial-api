<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Enum\InventoryStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        for ($i = 1; $i <= 15; $i++) {
            $product = new Product();

            // Inventory status
            $inventoryStatus = InventoryStatus::OUTOFSTOCK;
            if ($i % 2 === 0) {
                $inventoryStatus = InventoryStatus::INSTOCK;
            } elseif ($i % 3 === 0) {
                $inventoryStatus = InventoryStatus::LOWSTOCK;
            }
            $product->setCode('P00' . $i);
            $product->setName('Product ' . $i);
            $product->setDescription('Description of the product ' . $i);
            $product->setImage('image_of_product' . $i . '.jpg');
            $product->setCategory('Category of the product ' . rand(9, 19)); // Random category
            $product->setPrice(rand(100, 500)); // Random price
            $product->setQuantity(rand(1, 100));
            $product->setInternalReference('REF00' . $i);
            $product->setShellId(rand(1, 5));
            $product->setInventoryStatus($inventoryStatus);
            $product->setRating(rand(1, 5));
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($product);
        }
        $manager->flush();
    }
}
