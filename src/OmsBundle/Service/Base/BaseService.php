<?php


namespace OmsBundle\Service\Base;

class BaseService implements BaseServiceInterface
{

    /**
     * @param $object
     * @return object
     * @throws \Exception
     */
    public function setDateAdded($object)
    {
        $object->setDateadded(new \DateTime());
        return $object;
    }
}