<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Role;
use OmsBundle\Entity\User;
use OmsBundle\Service\Roles\RoleServiceInteface;
use OmsBundle\Service\Users\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * User controller.
 *
 * @Route("admin/user")
 */
class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function indexAction()
    {
        return $this->render('user/index.html.twig', array(
            'users' => $this->userService->findAllUsers(),
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new", methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function new()
    {
        return $this->render('user/new.html.twig', array(
            'form' => $this->createForm('OmsBundle\Form\UserType')->createView(),
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function newProcess(Request $request)
    {
        $user = new User ();
        $form = $this->createForm('OmsBundle\Form\UserType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $user->setDateAdded(new \DateTime());
            $this->userService->save($user);
        }
        return $this->redirectToRoute('user_show', array('id' => $user->getId()));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show", methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param User $user
     * @return Response
     */
    public function showAction(User $user)
    {
        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $this->createDeleteForm($user)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $this->createForm('OmsBundle\Form\UserType', $user)->createView(),
            'delete_form' => $this->createDeleteForm($user)->createView(),

        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function editProcess(Request $request, User $user)
    {
        $editForm = $this->createForm('OmsBundle\Form\UserType', $user);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->userService->edit($user);
           }
        return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $this->userService->delete($user);
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return FormInterface
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
