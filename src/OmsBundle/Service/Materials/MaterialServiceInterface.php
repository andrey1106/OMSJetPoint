<?php


namespace OmsBundle\Service\Materials;


use OmsBundle\Entity\Material;

interface MaterialServiceInterface
{
    public function save(Material $material);
    public function edit(Material $material);
    public function delete(Material $material);

}