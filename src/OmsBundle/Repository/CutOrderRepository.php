<?php

namespace OmsBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Mapping;
use OmsBundle\Entity\CutOrder;

/**
 * CutOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CutOrderRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em,
                                Mapping\ClassMetadata $metaData = null)
    {
        parent::__construct($em,
            $metaData == null ?
                new Mapping\ClassMetadata(CutOrder::class) :
                $metaData
        );
    }

    /**
     * @param CutOrder $cutOrder
     * @throws ORMException
     */
    public function insert(CutOrder $cutOrder)
    {
        try {
            $this->_em->persist($cutOrder);
            $this->_em->flush();
        } catch (OptimisticLockException $e) {

        }
    }

    /**
     * @param CutOrder $cutOrder
     * @throws ORMException
     */
    public function update(CutOrder $cutOrder)
    {
        try {
            $this->_em->merge($cutOrder);
            $this->_em->flush();
        } catch (OptimisticLockException $e) {

        }
    }

    /**
     * @param CutOrder $cutOrder
     * @throws ORMException
     */
    public function remove(CutOrder $cutOrder)
    {
        try {
            $this->_em->remove($cutOrder);
            $this->_em->flush();
        } catch (OptimisticLockException $e) {

        }
    }
}
