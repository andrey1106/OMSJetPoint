<?php


namespace OmsBundle\Service\Products;


use OmsBundle\Entity\Product;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ProductServiceInterface
{
    public function save(Product $product);
    public function edit(Product $product);
    public function delete(Product $product);
    public function findAllProducts();
    public function uploadImage(Product $product,UploadedFile $productFile);
    public function removeImage(Product $product);
}