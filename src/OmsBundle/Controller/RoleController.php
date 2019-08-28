<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Role;
use OmsBundle\Service\Roles\RoleServiceInteface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Role controller.
 *
 * @Route("admin/role")
 */
class RoleController extends Controller
{
    private $roleService;
    public function __construct(RoleServiceInteface $roleService)
    {
        $this->roleService=$roleService;
    }

    /**
     * Lists all role entities.
     *
     * @Route("/", name="role_index", methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        return $this->render('role/index.html.twig', array(
            'roles' => $this->getDoctrine()->getManager()
                ->getRepository('OmsBundle:Role')->findAll(),
        ));
    }

    /**
     * Creates a new role entity.
     *
     * @Route("/new", name="role_new", methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function new(Request $request)
    {
        return $this->render('role/new.html.twig', array(
             'form' => $this->createForm('OmsBundle\Form\RoleType')->createView(),
        ));
    }
    /**
     * Creates a new role entity.
     *
     * @Route("/new", name="new_save", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function newProcess(Request $request)
    {   $role= new Role();
        $form=$this->createForm('OmsBundle\Form\RoleType',$role);
        $form->handleRequest($request);
        $this->roleService->saveRole($role);

        return $this->redirectToRoute('role_show', array('id' => $role->getId()));
    }



    /**
     * Finds and displays a role entity.
     *
     * @Route("/{id}", name="role_show",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function showAction(Role $role)
    {
        $deleteForm = $this->createDeleteForm($role);

        return $this->render('role/show.html.twig', array(
            'role' => $role,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing role entity.
     *
     * @Route("/{id}/edit", name="role_edit",methods={"GET", "POST"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Role $role)
    {
        $deleteForm = $this->createDeleteForm($role);
        $editForm = $this->createForm('OmsBundle\Form\RoleType', $role);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('role_edit', array('id' => $role->getId()));
        }

        return $this->render('role/edit.html.twig', array(
            'role' => $role,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a role entity.
     *
     * @Route("/{id}", name="role_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Role $role)
    {
        $form = $this->createDeleteForm($role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($role);
            $em->flush();
        }

        return $this->redirectToRoute('role_index');
    }

    /**
     * Creates a form to delete a role entity.
     *
     * @param Role $role The role entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Role $role)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('role_delete', array('id' => $role->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
