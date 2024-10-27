<?php

namespace App\Controller;

//Entities
use App\Entity\Product;

//Services
use App\Service\ProductService;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/products')]
class ProductController extends AbstractController
{

    public function __construct(private ProductService $productService, private SerializerInterface $serializer)
    {
    }

    #[Route('/', methods: ['GET'])]
    public function getAllProducts(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        $jsonProducts = $this->serializer->serialize($products, 'json', ['groups' => ['product:read']]);
        return new JsonResponse($jsonProducts, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getProduct(int $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        //if()
        if (!$product) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($product);
    }

    #[Route('/', methods: ['POST'])]
    public function createProduct(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $product = new Product();

        if(empty($date["code"]) || empty($date["code"]))

        $this->productService->createProduct($product, $data);

        return new JsonResponse($product, Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PATCH'])]
    public function updateProduct(Request $request, int $id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        // Update fields
        // $product->setName($data['name']);

        $this->productService->updateProduct($product);
        return new JsonResponse($product);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteProduct(Product $product): JsonResponse
    {

        $this->productService->deleteProduct($product);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
