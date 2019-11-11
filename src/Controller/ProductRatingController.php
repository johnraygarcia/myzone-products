<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductRating;
use App\Entity\User;
use App\Service\ProductRatingService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class ProductRatingController extends AbstractFOSRestController
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ProductRatingService $productRatingService
     */
    private $productRatingService;

    public function __construct(
        EntityManagerInterface $em,
        ProductRatingService $productRatingService
    ) {
        $this->entityManager = $em;
        $this->productRatingService = $productRatingService;
    }

    /**
     * @Route("/product_rating", methods={"POST"})
     * @ParamConverter("product", converter="fos_rest.request_body")
     * 
     * @SWG\Parameter(
     *      name="form",
     *      in="body",
     *      description="Product data",
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              type="integer",
     *              property="id",
     *              example="1"
     *          )
     *      )
     * )
     * 
     * @SWG\Parameter(
     *      name="rating",
     *      in="query",
     *      type="integer",
     *      description="Users rating of the product from 1-5",
     * )
     * 
     * @SWG\Response(
     *      response=202,
     *      description="Product rating created"
     * )
     * 
     * @SWG\Parameter( 
     *      name="Authorization", 
     *      in="header", 
     *      required=true, 
     *      type="string", 
     *      default="Bearer TOKEN", 
     *      description="Authorization" 
     * )
     * 
     * @Security(name="Bearer")
     * @SWG\Tag(name="Products")
     * @return FOS\RestBundle\View
     */
    public function craeteProductRating(
        Product $product, 
        Request $request,
        UserService $userService) {

        $rating = $request->get('rating') <= 5 
            ? $request->get('rating') : 1;

        $managedProduct = $this->entityManager
            ->getRepository(Product::class)
            ->find($product->getId());

        /**
         * @var User $user
         */
        $user = $userService->getCurrentUser();

        $managedUser = $this->entityManager
            ->getRepository(User::class)
            ->find($user->getId());

        // Check if user has already rated this product, 
        // update it if it exists
        $usersProductRating = $this->productRatingService
            ->getProductRating($product, $user);
        
        $usersProductRating
            ->setRating($rating)
            ->setProduct($managedProduct)
            ->setUser($managedUser);

        $this->entityManager->persist($managedUser);
        $this->entityManager->persist($managedProduct);
        $this->entityManager->persist($usersProductRating);
        $this->entityManager->flush();

        return $this->view("User's product rating saved", Response::HTTP_ACCEPTED);
    }
}
