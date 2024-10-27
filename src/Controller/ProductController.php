<?php

namespace App\Controller;

//Entities
use App\Entity\Product;

//Services
use App\Service\ProductService;

//Repositories
use App\Repository\ProductRepository;

use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/products')]
class ProductController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private ProductRepository $productRepository, private ProductService $productService, private SerializerInterface $serializer, private ValidatorInterface $validator)
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
    public function getProduct(?Product $product, SerializerInterface $serializer): JsonResponse
    {
        if (!$product) {
            return new JsonResponse(["code" => Response::HTTP_NOT_FOUND, "message" => "Produit introuvable!"],JsonResponse::HTTP_BAD_REQUEST );
        }
        $data = $serializer->serialize($product, 'json', ['groups' => ['product:read']]);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('', methods: ['POST'])]
    public function createProduct(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        //Desérialisation de données
        try {
           $product = $serializer->deserialize($request->getContent(), Product::class, 'json', [
                DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true,
            ]);
            $this->productService->createProduct($product);
        } catch (PartialDenormalizationException $e) {
            //Contourner les exceptions générées à cause des Asserts
            $violations = new ConstraintViolationList();
            /** @var NotNormalizableValueException $exception */
            foreach ($e->getErrors() as $exception) {
                $message = sprintf('Le type du champ est "%s" ("%s" fourni).', implode(', ', $exception->getExpectedTypes()), $exception->getCurrentType());
                $errors[] = [
                    'property' => $exception->getPath(),
                    'message' => $message
                ];
            }

            return new JsonResponse(
                ["code" => Response::HTTP_BAD_REQUEST, "errors" => $errors],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(["code" => 200, "message" => "Création faite avec succès!"]);
    }

    #[Route('/{id}', methods: ['PATCH'])]
    public function updateProduct(?Product $product, Request $request, SerializerInterface $serializer): JsonResponse
    {
        dump($product);
        if (!$product) {
            return new JsonResponse(["code" => Response::HTTP_NOT_FOUND, "message" => "Produit introuvable!"],JsonResponse::HTTP_BAD_REQUEST );
        }
        //Deserialisation
        try {
            $serializer->deserialize($request->getContent(), Product::class, 'json', [
                DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true, 'object_to_populate' => $product
            ]);

        } catch (PartialDenormalizationException $e) {
            //Contourner les exceptions générées à cause des Asserts ($validator->validate() n'a pas catché ses erreurs)
            foreach ($e->getErrors() as $exception) {
                $message = sprintf('Le type du champ est "%s" ("%s" fourni).', implode(', ', $exception->getExpectedTypes()), $exception->getCurrentType());
                $errors[] = [
                    'property' => $exception->getPath(),
                    'message' => $message
                ];
            }

            return new JsonResponse(
                ["code" => Response::HTTP_BAD_REQUEST, "errors" => $errors],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        $this->productService->updateProduct($product);
        return new JsonResponse(["code" => 200, "message" => "Modification faite avec succès!"]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteProduct(?Product $product): JsonResponse
    {
        if (!$product) {
            return new JsonResponse(["code" => Response::HTTP_NOT_FOUND, "message" => "Produit introuvable!"],JsonResponse::HTTP_BAD_REQUEST );
        }
        $this->productService->deleteProduct($product);
        return new JsonResponse(["code" => 200, "message" => "Suppression faite avec succès!"]);
    }
}
