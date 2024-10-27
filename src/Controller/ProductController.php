<?php

namespace App\Controller;

//Entities
use App\Entity\Product;

//Services
use App\Service\ProductService;

use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/products')]
class ProductController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private ProductService $productService, private SerializerInterface $serializer, private ValidatorInterface $validator)
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
        if (!$product) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($product);
    }

    #[Route('', methods: ['POST'])]
    public function createProduct(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $product = new Product();

        //Validation
        $errors = $this->validator->validate($product);
        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath();// .": ".$error->getMessage() ;
            }

            return new JsonResponse([
                'code' => 400,
                'errors' => $errorMessages
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
        $serializer->deserialize($request->getContent(), Product::class, 'json', ['object_to_populate' => $product]);
        $this->productService->createProduct($product);
        return new JsonResponse(["code" => 200, "message" => "Création faite avec succès!"]);
    }

    #[Route('/{id}', methods: ['PATCH'])]
    public function updateProduct(Product $product, Request $request, SerializerInterface $serializer): JsonResponse
    {
        if (!$product) {
            return new JsonResponse(["code" => Response::HTTP_NOT_FOUND, "message" => "Produit introuvable!"],JsonResponse::HTTP_BAD_REQUES );
        }
        //Validation
        $errors = $this->validator->validate($product);
        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() .": ".$error->getMessage() ;
            }

            return new JsonResponse([
                'code' => 400,
                'errors' => $errorMessages
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Déserialisation vers un objet produit
        $serializer->deserialize($request->getContent(), Product::class, 'json', ['object_to_populate' => $product]);

        return new JsonResponse(["code" => 200, "message" => "Modification faite avec succès!"]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteProduct(Product $product): JsonResponse
    {
        if (!$product) {
            return new JsonResponse(["code" => Response::HTTP_NOT_FOUND, "message" => "Produit introuvable!"],JsonResponse::HTTP_BAD_REQUES );
        }
        $this->productService->deleteProduct($product);
        return new JsonResponse(["code" => 200, "message" => "Suppression faite avec succès!"]);
    }
}
