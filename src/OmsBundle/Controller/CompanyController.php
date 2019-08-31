<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Company;
use OmsBundle\Service\Companies\CompanyServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    public function __construct(CompanyServiceInterface $companyService)
    {
        $this->companyService = $companyService;
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
     * @Route("/new", name="company_new",methods={"GET", "POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm('OmsBundle\Form\CompanyType', $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $company->setDateAdded(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('company_show', array('id' => $company->getId()));
        }

        return $this->render('company/new.html.twig', array(
            'company' => $company,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="company_show",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     */
    public function showAction(Company $company)
    {
        $deleteForm = $this->createDeleteForm($company);

        return $this->render('company/show.html.twig', array(
            'company' => $company,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}/edit", name="company_edit",methods={"GET", "POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function editAction(Request $request, Company $company)
    {
        $deleteForm = $this->createDeleteForm($company);
        $editForm = $this->createForm('OmsBundle\Form\CompanyType', $company);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('company_edit', array('id' => $company->getId()));
        }

        return $this->render('company/edit.html.twig', array(
            'company' => $company,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a company entity.
     *
     * @Route("/{id}", name="company_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function deleteAction(Request $request, Company $company)
    {
        $form = $this->createDeleteForm($company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($company);
            $em->flush();
        }

        return $this->redirectToRoute('company_index');
    }

    /**
     * Creates a form to delete a company entity.
     *
     * @param Company $company The company entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Company $company)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('company_delete', array('id' => $company->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
