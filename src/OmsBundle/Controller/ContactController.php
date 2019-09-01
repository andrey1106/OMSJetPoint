<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Company;
use OmsBundle\Entity\Contact;

use OmsBundle\Service\Companies\CompanyServiceInterface;
use OmsBundle\Service\Contacts\ContactServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contact controller.
 *
 * @Route("contact")
 */
class ContactController extends Controller
{
    /**
     * @var ContactServiceInterface
     */
    private $contactService;
    private $companyService;

    public function __construct(ContactServiceInterface $contactService, CompanyServiceInterface $companyService)
    {
        $this->contactService = $contactService;
        $this->companyService = $companyService;
    }

    /**
     * Lists all contact entities.
     *
     * @Route("/", name="contact_index",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     */
    public function indexAction()
    {
        return $this->render('contact/index.html.twig', array(
            'contacts' => $this->contactService->findAllContacts(),
        ));
    }

    /**
     * Creates a new contact entity.
     *
     * @Route("/new/{companyid}", name="contact_new",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param null $companyid
     * @return Response
     */
    public function new($companyid = null)
    {
        $contact = new Contact();
        if ($companyid) {
            $company = $this->companyService->findOneCompanyByID($companyid);
            $contact->setCompany($company);
        }
        $form = $this->createForm('OmsBundle\Form\ContactType', $contact);
        if ($companyid) {
            $form->remove('company');
        }

        return $this->render('contact/new.html.twig', array(
            'contact' => $contact,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new contact entity.
     *
     * @Route("/new/{companyid}", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function newProcess(Request $request, $companyid = null)
    {
        $contact = new Contact();

        $form = $this->createForm('OmsBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($companyid) {
                $company = $this->companyService->findOneCompanyByID($companyid);
              } else {
                $company = $this->companyService->findOneCompanyByID($contact->getCompany());
            }
            $contact->setDateAdded(new \DateTime());
            $contact->setCompany($company);
            $this->contactService->save($contact);
        }
        return $this->redirectToRoute('contact_show', array('id' => $contact->getId()));
    }

    /**
     * Finds and displays a contact entity.
     *
     * @Route("/{id}", name="contact_show",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     * @param Contact $contact
     * @return Response
     */
    public function showAction(Contact $contact)
    {
        return $this->render('contact/show.html.twig', array(
            'contact' => $contact,
            'delete_form' => $this->createDeleteForm($contact)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Contact $contact
     *
     * @return Response
     */
    public function edit(Contact $contact)
    {
        return $this->render('contact/edit.html.twig', array(
            'contact' => $contact,
            'edit_form' => $this->createForm('OmsBundle\Form\ContactType', $contact)->createView(),
            'delete_form' => $this->createDeleteForm($contact)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit",methods={"GET", "POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function editProcess(Request $request, Contact $contact)
    {
        $editForm = $this->createForm('OmsBundle\Form\ContactType', $contact);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->contactService->edit($contact);
        }
        return $this->redirectToRoute('contact_edit', array('id' => $contact->getId()));
    }

    /**
     * Deletes a contact entity.
     *
     * @Route("/{id}", name="contact_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->delete($contact);
        }

        return $this->redirectToRoute('contact_index');
    }

    /**
     * Creates a form to delete a contact entity.
     *
     * @param Contact $contact The contact entity
     *
     * @return FormInterface
     */
    private function createDeleteForm(Contact $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contact_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
