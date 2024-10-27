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
                $message = sprintf('Le type du "%s" ("%s" donnés).', implode(', ', $exception->getExpectedTypes()), $exception->getCurrentType());
                $parameters = [];
                if ($exception->canUseMessageForUser()) {
                    $parameters['hint'] = $exception->getMessage();
                }
                $violations->add(new ConstraintViolation($message, '', $parameters, null, $exception->getPath(), null));
            }

            return $this->json($violations, 400);
        }


        return new JsonResponse(["code" => 200, "message" => "Création faite avec succès!"]);
    }

    #[Route('/{id}', methods: ['PATCH'])]
    public function updateProduct(Product $product, Request $request, SerializerInterface $serializer): JsonResponse
    {

        if (!$this->productRepository->find($product->getId())) {
            return new JsonResponse(["code" => Response::HTTP_NOT_FOUND, "message" => "Produit introuvable!"],JsonResponse::HTTP_BAD_REQUEST );
        }
        //Deserialisation
        try {
            $deserialized_product = $serializer->deserialize($request->getContent(), Product::class, 'json', [
                DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true, 'object_to_populate' => $product
            ]);
            $this->productService->updateProduct($product);
        } catch (PartialDenormalizationException $e) {
            //Contourner les exceptions générées à cause des Asserts ($validator->validate() n'a pas catché ses erreurs)
            $violations = new ConstraintViolationList();
            /** @var NotNormalizableValueException $exception */
            foreach ($e->getErrors() as $exception) {
                $message = sprintf('Le type "%s" (affecté à "%s" ).', implode(', ', $exception->getExpectedTypes()), $exception->getCurrentType());
                $parameters = [];
                if ($exception->canUseMessageForUser()) {
                    $parameters['hint'] = $exception->getMessage();
                }
                $violations->add(new ConstraintViolation($message, '', $parameters, null, $exception->getPath(), null));
            }

            return $this->json($violations, 400);
        }

        return new JsonResponse(["code" => 200, "message" => "Modification faite avec succès!"]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteProduct($id): JsonResponse
    {
        if (!$product = $this->productRepository->find($id)) {
            return new JsonResponse(["code" => Response::HTTP_NOT_FOUND, "message" => "Produit introuvable!"],JsonResponse::HTTP_BAD_REQUEST );
        }
        $this->productService->deleteProduct($product);
        return new JsonResponse(["code" => 200, "message" => "Suppression faite avec succès!"]);
    }
}
