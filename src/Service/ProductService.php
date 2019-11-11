<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

class ProductService {

    /**
     * @return string
     */
    public function filteredOrderBy($sortField=null, $sortOrder=null) {
        
        $allowedSortFields = [
            "id" => "p.id" , 
            "name" => "p.name", 
            "createdAt" => "p.createdAt"
        ];

        $allowedOrder = [
            "asc" => "asc" , 
            "desc" => "desc"
        ];

        $sf = "p.name";
        if (array_key_exists($sortField, $allowedSortFields)) {
            $sf = $allowedSortFields[$sortField];
        }

        $order = "asc";
        if (array_key_exists($sortOrder, $allowedOrder)) {
            $order = $allowedOrder[$sortOrder];
        }

        return "ORDER BY $sf $order";
    }
}