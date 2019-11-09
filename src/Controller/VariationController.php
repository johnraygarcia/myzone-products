<?php

namespace App\Controller;

use App\Entity\Variation;
use App\Entity\VariationValue;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class VariationController extends AbstractFOSRestController
{
     /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $em) {
        $this->entityManager = $em;
    }

    /** 
     * @Route("/variations", methods={"GET","HEAD"})
     */
    public function getList() {
        $variations = $this->entityManager
            ->getRepository(Variation::class)
            ->findAll();

        return $this->view($variations, Response::HTTP_OK);
    }

    /**
     * @Route("/variations/{id}", methods={"GET", "HEAD"})
     **/
    public function getById(int $id) {
        $variation = $this->entityManager
            ->getRepository(Variation::class)
            ->find($id);
        
        if (!$variation) {
            throw $this->createNotFoundException(
                'No variation found for id '.$variation->getId()
            );
        }

        return $this->view($variation, Response::HTTP_OK);
    }

    /**
     * @Route("/variations", methods={"POST"})
     * @ParamConverter("variation", converter="fos_rest.request_body")
     * @return FOS\RestBundle\View
     */
    public function create(Variation $variation) {
        $this->entityManager->persist($variation);
        $this->entityManager->flush();
        return $this->view($variation, Response::HTTP_CREATED);
    }

    /**
     * @Route("/variations", methods={"PUT"})
     * @ParamConverter("variant", converter="fos_rest.request_body")
     **/
    public function update(Variation $variant) {

         /**
         * @var Variation $variantManaged
         */
        $variantManaged = $this
            ->entityManager
            ->getRepository(Variation::class)
            ->find($variant->getId());

        if (!$variantManaged) {
            throw $this->createNotFoundException(
                'No variant found for id '.$variant->getId()
            );
        }

        $name = $variant->getName() ?: $variantManaged->getName();
        $variantManaged
            ->setName($name);

        $this->entityManager->flush($variantManaged);
        return $this->view("Variant is successfully updated.", Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/variations/{id}/value", methods={"POST"})
     */
    public function setValue($id, Request $request) {
        $value = $request->get("value");
        
        $variationValue = $this->entityManager
            ->getRepository(VariationValue::class
            )->findOneBy(["value" => $value]);

        if (!$variationValue) {
            throw new BadRequestHttpException("No value reference found for " . $value);
        }

        /**
         * @var Variation $variation
         */
        $variation = $this->entityManager
            ->getRepository(Variation::class)
            ->find($id);

        $variation->setVariationValue($variationValue);
        $this->entityManager->persist($variationValue);
        $this->entityManager->persist($variation);
        $this->entityManager->flush();

        return $this->view("Variant value is updated.", Response::HTTP_ACCEPTED);
    }
}
