<?php


namespace OmsBundle\Service\Contacts;


use OmsBundle\Entity\Contact;

interface ContactServiceInterface
{
    public function save(Contact $contact);
    public function edit(Contact $contact);
    public function delete(Contact $contact);
    public function findAllContacts();
}