<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\Status;
use App\Service\FileUploadService;
use App\Service\ProductService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class ProductController extends AbstractFOSRestController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ProductService $productService
     */
    private $productService;

    public function __construct(
        EntityManagerInterface $em,
        ProductService $productService
    ) {
        $this->entityManager = $em;
        $this->productService = $productService;
    }

    /** 
     * Paginated list of products
     * 
     * @Route("/products", methods={"GET"})
     * @SWG\Response(
     *      response=200,
     *      description="Returns a list of paginated products",
     *      @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref=@Model(type=Product::class, groups={"full"}))
     *      )
     * )
     * @SWG\Parameter(
     *      name="lastId",
     *      in="query",
     *      type="integer",
     *      description="The value of last id to be used as offset for the next set of records"
     * )
     * 
     * @SWG\Parameter(
     *      name="sortField",
     *      in="query",
     *      type="string",
     *      description="Sort by id, name, createdAt",
     *      default="name"
     * )
     * 
     * @SWG\Parameter(
     *      name="sortOrder",
     *      in="query",
     *      type="string",
     *      description="Sort list by asc=Ascending or by desc=Descending",
     *      default="asc"
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
     */
    public function getList(Request $request) {

        $itemsPerPage = 5;
        $activeStatus = $this->entityManager
            ->getRepository(Status::class)
            ->findOneBy(["name" => "Active"]);

        $lastId = $request->get('lastId') ?: 0;
        $sortField = $request->get('sortField') ?: "name";
        $sortOrder = $request->get('sortOrder') ?: "asc";
        $orderBy = $this->productService->filteredOrderBy($sortField, $sortOrder);

        $productList = $this->entityManager->createQuery("
            SELECT p, s FROM App\Entity\Product p
            JOIN p.status s
            WHERE p.id > :lastId 
            AND s.id=:statusId
            {$orderBy}
        ")
        ->setParameter('lastId', $lastId)
        ->setParameter('statusId', $activeStatus->getId())
        ->setMaxResults($itemsPerPage)
        ->getResult();

        return $this->view($productList, Response::HTTP_OK);
    }

    /**
     * Get specific product by id
     * 
     * @Route("/products/{id}", methods={"GET"})
     * @SWG\Response(
     *      response=200,
     *      description="An object of type Product"
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
     * @SWG\Tag(name="Products")
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
     * 
     * @SWG\Parameter(
     *      name="form",
     *      in="body",
     *      description="Product data",
     *      @SWG\Schema(
     *          type="object",
     *          @SWG\Property(
     *              type="string",
     *              property="name",
     *              example="My Product Name"
     *          ),
     *          @SWG\Property(
     *              type="string",
     *              property="description",
     *              example="My Product Description"
     *          ),
     *          @SWG\Property(
     *              type="float",
     *              property="price",
     *              example="23.32"
     *          ),
     *          @SWG\Property(
     *              type="integer",
     *              property="rating",
     *              example="5"
     *          )
     *      )
     * )
     * 
     * @SWG\Response(
     *      response=201,
     *      description="The created product object",
     *      @Model(type=Product::class, groups={"non_senstive_data"})
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
    public function create(Product $product) {

        $status = $this->entityManager
            ->getRepository(Status::class)
            ->findOneBy(["name" => "Active"]);

        $product
            ->setStatus($status);

        $this->entityManager->persist($product);
        $this->entityManager->persist($status);
        $this->entityManager->flush();
        
        return $this->view($product, Response::HTTP_CREATED);
    }
    
    /**
     * @Route("/products", methods={"PUT"})
     * @ParamConverter("product", converter="fos_rest.request_body")
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
     *          ),
     *          @SWG\Property(
     *              type="string",
     *              property="name",
     *              example="My Product Name"
     *          ),
     *          @SWG\Property(
     *              type="string",
     *              property="description",
     *              example="My Product Description"
     *          ),
     *          @SWG\Property(
     *              type="float",
     *              property="price",
     *              example="23.32"
     *          ),
     *          @SWG\Property(
     *              type="integer",
     *              property="rating",
     *              example="5"
     *          )
     *      )
     * )
     * 
     * @SWG\Response(
     *      response=201,
     *      description="The updated product object",
     *      @Model(type=Product::class, groups={"non_senstive_data"})
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
     * @SWG\Tag(name="Products")
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
     * Delete a product
     * 
     * @Route("/products", methods={"DELETE"})
     * @ParamConverter("product", converter="fos_rest.request_body")
     * 
     * @SWG\Parameter(
     *      name="form",
     *      in="body",
     *      description="Product data to be deleted",
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
     * @SWG\Response(
     *          response=202,
     *          description="Product is deleted."
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
     * @SWG\Tag(name="Products") 
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

        return $this->view("Product is deleted.", Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/products/{id}/images", methods={"POST"})
     * 
     * @SWG\Response(
     *          response=202,
     *          description="Object with link url to the created image",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  type="string",
     *                  property="url",
     *                  example="http://myzone-products.local/uploads/81d49a3477ffaf8c6fe6c85cfc0b4971.png"
     *          ),
     *      )
     * )
     * 
     * @SWG\Parameter( 
     *      name="file", 
     *      in="formData", 
     *      required=true, 
     *      type="file", 
     *      description="product image" 
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
     */
    public function uploadImages(Request $request, FileUploadService $fileUploadService) {

        $file = $request->files->get('file');
        $productId = $request->get('id');        
        $filename = $fileUploadService->doUpload($file, $this->getParameter('uploads_dir'));
        $url = $this->getParameter('static_asset_path') . $filename;

        $product = $this->entityManager
            ->getRepository(Product::class)
            ->find($productId);
        $productImage = new ProductImage();
        $productImage->setUrl($url);
        $productImage->setProduct($product);

        $this->entityManager->persist($product);
        $this->entityManager->persist($productImage);
        $this->entityManager->flush();

        return $this->view(["url" => $url], Response::HTTP_CREATED);
    }

    /**
     * Set the status of a product to deleted or active
     *  - To set to deleted status, pass a delete=1 query param in the request
     *  - To set to active status, ommit the delete query param in the request
     * 
     * @Route("/products/{id}/status", methods={"PATCH"})
     * @param Request $request
     * 
     * 
     * @SWG\Response(
     *          response=202,
     *          description="Product status is updated"
     *      )
     * )
     * 
     * @SWG\Parameter( 
     *      name="id", 
     *      in="path", 
     *      required=true, 
     *      type="string", 
     *      description="Id of product to update" 
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
     */
    function updateProductStatus(Request $request) {

        $delete = $request->get('delete');
        $productId = $request->get('id');

        /**
         * @var Product $product
         */
        $product = $this->entityManager
            ->getReference(Product::class, $productId);
        if ($delete==1) {
            $status = $this->entityManager
                ->getRepository(Status::class)->findOneBy([
                    "name" => "deleted"
                ]);
            
        } else {
            $status = $this->entityManager
                ->getRepository(Status::class)->findOneBy([
                    "name" => "Active"
                ]);
        }

        $product->setStatus($status);
        $this->entityManager->persist($product);
        $this->entityManager->persist($status);
        $this->entityManager->flush();

        return $this->view("Product status is updated", Response::HTTP_ACCEPTED);
    }
}
