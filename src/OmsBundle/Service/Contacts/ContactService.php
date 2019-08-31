<?php


namespace OmsBundle\Service\Contacts;


use Doctrine\ORM\ORMException;
use OmsBundle\Entity\Contact;
use OmsBundle\Repository\ContactRepository;

class ContactService implements ContactServiceInterface
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param Contact $contact
     * @return ORMException|\Exception|void
     */
    public function save(Contact $contact)
    {
        try {
            return $this->contactRepository->insert($contact);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param Contact $contact
     * @return ORMException|\Exception|void
     */
    public function edit(Contact $contact)
    {
        try {
            return $this->contactRepository->update($contact);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param Contact $contact
     * @return ORMException|\Exception|void
     */
    public function delete(Contact $contact)
    {
        try {
            return $this->contactRepository->remove($contact);
        } catch (ORMException $e) {
            return $e;
        }
    }

    public function findAllContacts()
    {
        return $this->contactRepository->findAll();
    }
}