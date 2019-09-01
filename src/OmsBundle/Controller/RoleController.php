<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Role;
use OmsBundle\Service\Roles\RoleServiceInteface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Role controller.
 *
 * @Route("admin/role")
 */
class RoleController extends Controller
{
    /**
     * @var RoleServiceInteface
     */
    private $roleService;

    public function __construct(RoleServiceInteface $roleService)
    {
        $this->roleService = $roleService;
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
            'roles' => $this->roleService->findAllRoles(),
        ));
    }

    /**
     * Creates a new role entity.
     *
     * @Route("/new", name="role_new", methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Request $request
     * @return Response
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function newProcess(Request $request)
    {
        $role = new Role();
        $form = $this->createForm('OmsBundle\Form\RoleType', $role);
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
     * @param Role $role
     * @return Response
     */
    public function showAction(Role $role)
    {
        return $this->render('role/show.html.twig', array(
            'role' => $role,
            'delete_form' => $this->createDeleteForm($role)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing role entity.
     *
     * @Route("/{id}/edit", name="role_edit",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        return $this->render('role/edit.html.twig', array(
            'role' => $role,
            'edit_form' => $this->createForm('OmsBundle\Form\RoleType', $role)->createView(),
            'delete_form' => $this->createDeleteForm($role)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing role entity.
     *
     * @Route("/{id}/edit",methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function editProcess(Request $request, Role $role)
    {
        $editForm = $this->createForm('OmsBundle\Form\RoleType', $role);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->roleService->edit($role);
        }
        return $this->redirectToRoute('role_edit', array('id' => $role->getId()));
    }

    /**
     * Deletes a role entity.
     *
     * @Route("/{id}", name="role_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Role $role)
    {
        $form = $this->createDeleteForm($role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->roleService->delete($role);
        }

        return $this->redirectToRoute('role_index');
    }


    /**
     * Creates a form to delete a role entity.
     *
     * @param Role $role The role entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Role $role)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('role_delete', array('id' => $role->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
