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
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

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
     * Get list of available product variations
     * 
     * @Route("/variations", methods={"GET"})
     * @SWG\Response(
     *      response=200,
     *      description="Returns a list of variation",
     *      @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Variation::class, groups={"full"}))
     *      )
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
     * @SWG\Tag(name="Variations")
     */
    public function getList() {
        $variations = $this->entityManager
            ->getRepository(Variation::class)
            ->findAll();

        return $this->view($variations, Response::HTTP_OK);
    }

    /**
     * Get Specific variation by id
     * 
     * @Route("/variations/{id}", methods={"GET"})
     * 
     * @SWG\Response(
     *      response=200,
     *      description="An object of type Variation",
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              type="integer",
     *              property="id",
     *              example="1"
     *          ),
     *          @SWG\Property(
     *              type="name",
     *              property="name",
     *              example="My Variations Description"
     *          )
     *      )
     *      
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
     * @Security(name="Bearer")
     * @SWG\Tag(name="Variations")
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
     * Create a new variation
     * 
     * @Route("/variations", methods={"POST"})
     * @ParamConverter("variation", converter="fos_rest.request_body")
     * 
     * @SWG\Parameter(
     *      name="form",
     *      in="body",
     *      description="Variation json data",
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              type="string",
     *              property="name",
     *              example="Variation name"
     *          )
     *      )
     * )
     * 
     * @SWG\Response(
     *      response=201,
     *      description="The created variation object",
     *      @Model(type=Variation::class, groups={"non_senstive_data"})
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
     * @SWG\Tag(name="Variations")
     * @return FOS\RestBundle\View
     */
    public function create(Variation $variation) {
        $this->entityManager->persist($variation);
        $this->entityManager->flush();
        return $this->view($variation, Response::HTTP_CREATED);
    }

    /**
     * Update a variation name
     * 
     * @Route("/variations", methods={"PUT"})
     * @ParamConverter("variant", converter="fos_rest.request_body")
     * 
     * @SWG\Parameter(
     *      name="form",
     *      in="body",
     *      description="Variation data",
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              type="integer",
     *              property="id",
     *              example="1"
     *          ),
     *          @SWG\Property(
     *              type="string",
     *              property="name",
     *              example="My updated variation name"
     *          )
     *      )
     * )
     * 
     * @SWG\Response(
     *      response=202,
     *      description="The updated variation object",
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              type="integer",
     *              property="id",
     *              example="1"
     *          ),
     *          @SWG\Property(
     *              type="name",
     *              property="name",
     *              example="My Variations Description"
     *          )
     *      )
     * )
     * @SWG\Parameter( 
     *      name="Authorization", 
     *      in="header", 
     *      required=true, 
     *      type="string", 
     *      default="Bearer TOKEN", 
     *      description="Authorization" 
     * )
     * @Security(name="Bearer")
     * @SWG\Tag(name="Variations")
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
     * Update the selected value of the variantion
     * 
     * @Route("/variations/{id}/value", methods={"POST"})
     * 
     * @SWG\Parameter(
     *      name="form",
     *      in="body",
     *      description="Variation data",
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              type="string",
     *              property="value",
     *              example="XL"
     *          )
     *      )
     * )
     * 
     * @SWG\Response(
     *      response=201,
     *      description="The updated variation object",
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              type="integer",
     *              property="id",
     *              example="1"
     *          ),
     *          @SWG\Property(
     *              type="string",
     *              property="name",
     *              example="My Variations Description"
     *          ),
     *          @SWG\Property(
     *              type="object",
     *              property="variation_value",
     *              @SWG\Property(
     *                  type="ingeger",
     *                  property="id",
     *                  example="1"
     *              ),
     *              @SWG\Property(
     *                  type="string",
     *                  property="value",
     *                  example="XXL"
     *              )
     *          )
     *      )
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
     * @Security(name="Bearer")
     * @SWG\Tag(name="Variations")
     */
    public function setValue(Request $request) {
        $value = $request->get("value");
        $id = $request->get("id");
        
        $variationValue = $this->entityManager
            ->getRepository(VariationValue::class)
            ->findOneBy(["value" => $value]);

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

        return $this->view($variation, Response::HTTP_ACCEPTED);
    }
}
