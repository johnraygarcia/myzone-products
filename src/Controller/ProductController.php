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
     * Paginated list of products
     * lastId query parameter provides hint where the next set of items will start
     * 
     * @Route("/products", methods={"GET","HEAD"})
     */
    public function getList(Request $request) {

        $itemsPerPage = 5;
        $activeStatus = $this->entityManager
            ->getRepository(Status::class)
            ->findOneBy(["name" => "Active"]);

        $lastId = $request->get('lastId') ?: 0;
        $productList = $this->entityManager->createQuery('
                SELECT p, s FROM App\Entity\Product p
                JOIN p.status s
                WHERE p.id > :lastId 
                AND s.id=:statusId
            ')
        ->setParameter('lastId', $lastId)
        ->setParameter('statusId', $activeStatus->getId())
        ->setMaxResults($itemsPerPage)
        ->getResult();

        return $this->view($productList, Response::HTTP_OK);
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

    /**
     * @Route("/products/{id}/images", methods={"POST"})
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
    }
}
