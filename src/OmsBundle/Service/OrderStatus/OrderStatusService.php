<?php


namespace OmsBundle\Service\OrderStatus;



use Doctrine\ORM\ORMException;
use OmsBundle\Entity\OrderStatus;
use OmsBundle\Repository\OrderStatusRepository;

class OrderStatusService implements OrderStatusServiceInterface
{
    /**
     * @var OrderStatusRepository
     */
    private $orderStatusRespository;
    public function __construct(OrderStatusRepository $orderStatusRepository)
    {
        $this->orderStatusRespository=$orderStatusRepository;
    }

    /**
     * @param OrderStatus $orderStatus
     * @throws ORMException
     */
    public function save(OrderStatus $orderStatus)
    {
        return $this->orderStatusRespository->insert($orderStatus);
    }

    /**
     * @param OrderStatus $orderStatus
     * @throws ORMException
     */
    public function edit(OrderStatus $orderStatus)
    {
        return $this->orderStatusRespository->update($orderStatus);
    }

    /**
     * @param OrderStatus $orderStatus
     *
     * @throws ORMException
     */
    public function delete(OrderStatus $orderStatus)
    {
           return $this->orderStatusRespository->remove($orderStatus);
    }

    public function findAllStatuses()
    {
        return $this->orderStatusRespository->findAll();
    }
}