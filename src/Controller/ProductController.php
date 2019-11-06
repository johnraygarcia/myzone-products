<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class ProductController extends AbstractFOSRestController
{
    public function getProductsListAction() {
        return [
            "message" => "get all products"
        ];
    }

    public function getProductsAction(int $id) {
        return [
            "message" => "get specific product by id" . $id
        ];
    }

    public function postProductsAction() {
        return [
            "message" => "create new product"
        ];
    }
    
    public function putProductsAction() {
        return [
            "message" => "update product"
        ];
    }

    public function patchProductsAction(int $id) {
        return [
            "message" => "patch product"
        ];
    }

    public function deleteProductsAction() {
        return [
            "message" => "delete product"
        ];
    }
}
