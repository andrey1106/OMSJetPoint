<?php


namespace OmsBundle\Service\OrderStatus;


use OmsBundle\Entity\OrderStatus;

interface OrderStatusServiceInterface
{
    public function save(OrderStatus $orderStatus);
    public function edit(OrderStatus $orderStatus);
    public function delete(OrderStatus $orderStatus);
    public function findAllStatuses();
}