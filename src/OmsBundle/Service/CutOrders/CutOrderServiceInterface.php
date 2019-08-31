<?php


namespace OmsBundle\Service\CutOrders;


use OmsBundle\Entity\CutOrder;

interface CutOrderServiceInterface
{
    public function save(CutOrder $cutOrder);
    public function edit(CutOrder $cutOrder);
    public function delete(CutOrder $cutOrder);
}