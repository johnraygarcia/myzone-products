<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Status;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends AbstractFOSRestController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $em) {
        $this->entityManager = $em;
    }

    /** 
     * @Route("/products", methods={"GET","HEAD"})
     */
    public function getList() {

        $activeStatus = $this->entityManager->getRepository(Status::class)->findOneBy(["name" => "Active"]);

        return $this->view(
            $this->entityManager
                ->getRepository(Product::class)
                ->findBy(["status" => $activeStatus->getId()]),  
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/products/{id}", methods={"GET"})
     **/
    public function getById(int $id) {
        $product = $this->entityManager
            ->getRepository(Product::class)
            ->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$product->getId()
            );
        }

        return $this->view($product, Response::HTTP_OK);
    }

    /**
     * @Route("/products", methods={"POST"})
     * @ParamConverter("product", converter="fos_rest.request_body")
     * @return FOS\RestBundle\View
     */
    public function create(Product $product) {

        $this->entityManager->persist($product);
        $this->entityManager->flush();
        
        return $this->view($product, Response::HTTP_CREATED);
    }
    
    /**
     * @Route("/products", methods={"PUT"})
     * @ParamConverter("product", converter="fos_rest.request_body")
     **/
    public function update(Product $product) {

        /**
         * @var Product $productManaged
         */
        $productManaged = $this
            ->entityManager
            ->getRepository(Product::class)
            ->find($product->getId());

        if (!$productManaged) {
            throw $this->createNotFoundException(
                'No product found for id '.$product->getId()
            );
        }

        $name = $product->getName() ?: $productManaged->getName();
        $description = $product->getDescription() ?: $productManaged->getDescription();
        $price = $product->getPrice() ?: $productManaged->getPrice();
        $rating = $product->getRating() ?: $productManaged->getRating();

        $productManaged
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setRating($rating);

        $this->entityManager->flush($productManaged);
        return $this->view("Product is successfully updated.", Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/products", methods={"DELETE"})
     * @ParamConverter("product", converter="fos_rest.request_body")
     */
    public function delete(Product $product) {
        $productManaged = $this
            ->entityManager
            ->getRepository(Product::class)
            ->find($product->getId());

        if (!$productManaged) {
            throw $this->createNotFoundException(
                'No product found for id '.$product->getId()
            );
        }

        $deletedStatus = $this->entityManager
            ->getRepository(Status::class)
            ->findOneBy(["name" => "Deleted"]);
        $productManaged
            ->setStatus($deletedStatus);

        $this->entityManager->persist($deletedStatus);
        $this->entityManager->persist($productManaged);
        $this->entityManager->flush($productManaged);

        return $this->view("Product is deleted.", Response::HTTP_OK);
    }
}
