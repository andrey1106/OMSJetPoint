<?php


namespace OmsBundle\Service\Prices;


use OmsBundle\Entity\Price;

interface PriceServiceInterface
{
    public function save(Price $price);
    public function edit(Price $price);
    public function delete(Price $price);
    public function calcPrice(Price $price);
}