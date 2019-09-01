<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Company;
use OmsBundle\Service\Companies\CompanyServiceInterface;
use OmsBundle\Service\Contacts\ContactServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Company controller.
 *
 * @Route("company")
 */
class CompanyController extends Controller
{
    /**
     * @var CompanyServiceInterface
     */
    private $companyService;
    private $contactService;

    public function __construct(CompanyServiceInterface $companyService,ContactServiceInterface $contactService)
    {
        $this->companyService = $companyService;
        $this->contactService=$contactService;
    }

    /**
     * Lists all company entities.
     *
     * @Route("/", name="company_index",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     */
    public function indexAction()
    {
        return $this->render('company/index.html.twig', array(
            'companies' => $this->companyService->findAllCompanies(),
        ));
    }

    /**
     * Creates a new company entity.
     *
     * @Route("/new", name="company_new",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function new()
    {
        return $this->render('company/new.html.twig', array(
            'form' => $this->createForm('OmsBundle\Form\CompanyType')->createView(),
        ));
    }

    /**
     * Creates a new company entity.
     *
     * @Route("/new", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function newProcess(Request $request)
    {
        $company = new Company();
        $form = $this->createForm('OmsBundle\Form\CompanyType', $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $company->setDateAdded(new \DateTime());
            $this->companyService->save($company);
        }
        return $this->redirectToRoute('company_show', array('id' => $company->getId()));
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="company_show",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     * @param Company $company
     * @return Response
     */
    public function showAction(Company $company)
    {
        return $this->render('company/show.html.twig', array(
            'company' => $company,
            'delete_form' => $this->createDeleteForm($company)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}/edit", name="company_edit",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Company $company
     * @return Response
     */
    public function edit(Company $company)
    {
        return $this->render('company/edit.html.twig', array(
            'company'=>$company,
            'edit_form' => $this->createForm('OmsBundle\Form\CompanyType', $company)->createView(),
            'delete_form' => $this->createDeleteForm($company)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}/edit", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param Company $company
     * @return RedirectResponse
     */
    public function editProcess(Request $request, Company $company)
    {
        $editForm = $this->createForm('OmsBundle\Form\CompanyType', $company);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->companyService->edit($company);
        }
        return $this->redirectToRoute('company_edit', array('id' => $company->getId()));
    }

    /**
     * Deletes a company entity.
     *
     * @Route("/{id}", name="company_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param Company $company
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Company $company)
    {
        $form = $this->createDeleteForm($company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($company->getContacts() as $contact){
            $this->contactService->delete($contact);
            }
            $this->companyService->delete($company);
        }

        return $this->redirectToRoute('company_index');
    }

    /**
     * Creates a form to delete a company entity.
     *
     * @param Company $company The company entity
     *
     * @return FormInterface
     */
    private function createDeleteForm(Company $company)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('company_delete', array('id' => $company->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
