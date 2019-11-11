<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ProductRating;
use App\Entity\User;
use App\Repository\ProductRatingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

class ProductRatingService {


    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ProductRatingRepository $productRatingRepository
     */
    private $productRatingRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProductRatingRepository $productRatingRepository
    ) {
        $this->entityManager = $em;
        $this->productRatingRepository = $productRatingRepository;
    }

    /**
     * @param Product $product
     * @param User $user
     * @return ProductRating
     */
    public function getProductRating(Product $product, User $user) {

        try {
            return $this->entityManager->getRepository(ProductRating::class)
            ->createQueryBuilder('pr')
            ->innerJoin('pr.user', 'u')
            ->innerJoin('pr.product', 'prod')
            ->where('u.id = :userId')
            ->andWhere('prod.id = :productId')
            ->setParameter('userId', $user->getId())
            ->setParameter('productId', $product->getId())
            ->getQuery()
            ->getSingleResult();
        } catch(NoResultException $e) {
            return new ProductRating();
        }
    }

    /**
     * @param Product $product
     */
    public function getAverage(Product $product) {


        $s = $this->entityManager
            ->createQuery("
                SELECT AVG(product.rating) AS aveRating 
                FROM App\Entity\ProductRating pr
                JOIN pr.product
                WHERE product.id=:id
            ")
        ->setParameter('id', $product->getId())
        ->getScalarResult();

        var_dump($s);die();

    }
}