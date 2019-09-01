<?php


namespace OmsBundle\Service\CutOrders;


use Doctrine\ORM\ORMException;
use OmsBundle\Entity\CutOrder;
use OmsBundle\Repository\CutOrderRepository;

class CutOrderService implements CutOrderServiceInterface
{
    /**
     * @var CutOrderRepository
     */
    private $curOrderRepository;
    public function __construct(CutOrderRepository $curOrderRepository)
    {
        $this->curOrderRepository=$curOrderRepository;
    }

    /**
     * @param CutOrder $cutOrder
     * @throws ORMException
     */
    public function save(CutOrder $cutOrder)
    {
        return $this->curOrderRepository->insert($cutOrder);
    }

    /**
     * @param CutOrder $cutOrder
     * @throws ORMException
     */
    public function edit(CutOrder $cutOrder)
    {
        return $this->curOrderRepository->update($cutOrder);
    }

    /**
     * @param CutOrder $cutOrder
     * @throws ORMException
     */
    public function delete(CutOrder $cutOrder)
    {
       return $this->curOrderRepository->remove($cutOrder);
    }

    /**
     * @return array
     */
    public function findAllOrders()
    {
      return $this->curOrderRepository->findAll();
    }
}