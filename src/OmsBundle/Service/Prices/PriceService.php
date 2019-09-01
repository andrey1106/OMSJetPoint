<?php


namespace OmsBundle\Service\Prices;



use Doctrine\ORM\ORMException;
use OmsBundle\Entity\Price;
use OmsBundle\Repository\PriceRepository;

class PriceService implements PriceServiceInterface
{
    /**
     * @var PriceRepository
     */
    private $priceRepository;
    public function __construct(PriceRepository $priceRepository)
    {
        $this->priceRepository=$priceRepository;
    }

    /**
     * @param Price $price
     * @throws ORMException
     */
    public function save(Price $price)
    {
        return $this->priceRepository->insert($price);
    }

    /**
     * @param Price $price
     * @throws ORMException
     */
    public function edit(Price $price)
    {
        $this->priceRepository->update($price);
    }

    /**
     * @param Price $price
     * @throws ORMException
     */
    public function delete(Price $price)
    {
        $this->priceRepository->remove($price);
    }

    /**
     * @param Price $price
     * @return Price
     */
    public function calcPrice(Price $price)
    {
        $price->setPrice(
            ((($price->getProduct()->getlineCut()/$price->getMaterial()->getcutSpeed())+
            (($price->getProduct()->getholes()*$price->getMaterial()->getdrillingTime())/60))*2.5)*
            $price->getQuantity()
        );
        return $price;
    }
}