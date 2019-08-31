<?php

namespace OmsBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Mapping;
use OmsBundle\Entity\Contact;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em,
                                Mapping\ClassMetadata $metaData = null)
    {
        parent::__construct($em,
            $metaData == null ?
                new Mapping\ClassMetadata(Contact::class) :
                $metaData
        );
    }

    /**
     * @param Contact $contact
     * @throws ORMException
     */
    public function insert(Contact $contact)
    {
        try {
            $this->_em->persist($contact);
            $this->_em->flush();
        } catch (OptimisticLockException $e) {

        }
    }

    /**
     * @param Contact $contact
     * @throws ORMException
     */
    public function update(Contact $contact)
    {
        try {
            $this->_em->merge($contact);
            $this->_em->flush();
        } catch (OptimisticLockException $e) {

        }
    }

    /**
     * @param Contact $contact
     * @throws ORMException
     */
    public function remove(Contact $contact)
    {
        try {
            $this->_em->remove($contact);
            $this->_em->flush();
        } catch (OptimisticLockException $e) {

        }
    }
}
