<?php


namespace OmsBundle\Service\Products;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\ORMException;
use OmsBundle\Entity\Product;
use OmsBundle\Repository\ProductRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ProductService implements ProductServiceInterface
{
    private $productRespository;
    private $container;
    public function __construct(ProductRepository $productRepository,ContainerInterface $container)
    {
        $this->productRespository = $productRepository;
        $this->container=$container;
    }

    /**
     * @param Product $product
     * @return ORMException|\Exception|void
     *
     */
    public function save(Product $product)
    {
        try {
            return $this->productRespository->insert($product);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param Product $product
     * @return ORMException|\Exception|void
     */
    public function edit(Product $product)
    {
        try {
            return $this->productRespository->update($product);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param Product $product
     * @return ORMException|\Exception|void
     */
    public function delete(Product $product)
    {
        try {
            return $this->productRespository->remove($product);
        } catch (ORMException $e) {
            return $e;
        }

    }

    /**
     * @return array
     */
    public function findAllProducts()
    {
        return $this->productRespository->findAll();
    }

    /**
     * @param $productFile
     * @param Product $product
     * @return Product
     */
    public function uploadImage(Product $product,UploadedFile $productFile)
    {
        /**
         * @var UploadedFile $productFile
         */
        if ($productFile) {
            $fileName = md5(uniqid()) . "." . $productFile->guessExtension();
            $productFile->move($this->container->getParameter('product_image_directory'), $fileName);
            $product->setPicture($fileName);
        }
        return  $product;
    }
}