<?php


namespace OmsBundle\Service\Products;


use OmsBundle\Entity\Product;

interface ProductServiceInterface
{
    public function save(Product $product);
    public function edit(Product $product);
    public function delete(Product $product);
}