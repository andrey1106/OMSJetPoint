<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\OrderStatus;
use OmsBundle\Service\OrderStatus\OrderStatusServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Orderstatus controller.
 *
 * @Route("admin/orderstatus")
 */
class OrderStatusController extends Controller
{
    /**
     * @var OrderStatusServiceInterface
     */
    private $orderStatusService;

    public function __construct(OrderStatusServiceInterface $orderStatusService)
    {
        $this->orderStatusService = $orderStatusService;
    }

    /**
     * Lists all orderStatus entities.
     *
     * @Route("/", name="admin_orderstatus_index",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        return $this->render('orderstatus/index.html.twig', array(
            'orderStatuses' => $this->orderStatusService->findAllStatuses(),
        ));
    }

    /**
     * Creates a new orderStatus entity.
     *
     * @Route("/new", name="admin_orderstatus_new",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function new()
    {
        return $this->render('orderstatus/new.html.twig', array(
            'form' => $this->createForm('OmsBundle\Form\OrderStatusType')->createView(),
        ));
    }

    /**
     * Creates a new orderStatus entity.
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
        $orderStatus = new Orderstatus();
        $form = $this->createForm('OmsBundle\Form\OrderStatusType', $orderStatus);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $orderStatus->setDateAdded(new \DateTime());
            $this->orderStatusService->save($orderStatus);
        }
        return $this->redirectToRoute('admin_orderstatus_show', array('id' => $orderStatus->getId()));
    }

    /**
     * Finds and displays a orderStatus entity.
     *
     * @Route("/{id}", name="admin_orderstatus_show",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param OrderStatus $orderStatus
     * @return Response
     */
    public function showAction(OrderStatus $orderStatus)
    {
        return $this->render('orderstatus/show.html.twig', array(
            'orderStatus' => $orderStatus,
            'delete_form' => $this->createDeleteForm($orderStatus)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing orderStatus entity.
     *
     * @Route("/{id}/edit", name="admin_orderstatus_edit",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(OrderStatus $orderStatus)
    {
        return $this->render('orderstatus/edit.html.twig', array(
            'orderStatus' => $orderStatus,
            'edit_form' => $this->createForm('OmsBundle\Form\OrderStatusType', $orderStatus)->createView(),
            'delete_form' => $this->createDeleteForm($orderStatus)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing orderStatus entity.
     *
     * @Route("/{id}/edit", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Request $request
     * @param OrderStatus $orderStatus
     * @return RedirectResponse
     */
    public function editProcess(Request $request, OrderStatus $orderStatus)
    {
        $editForm = $this->createForm('OmsBundle\Form\OrderStatusType', $orderStatus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->orderStatusService->edit($orderStatus);
         }
        return $this->redirectToRoute('admin_orderstatus_edit', array('id' => $orderStatus->getId()));
    }

    /**
     * Deletes a orderStatus entity.
     *
     * @Route("/{id}", name="admin_orderstatus_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Request $request
     * @param OrderStatus $orderStatus
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, OrderStatus $orderStatus)
    {
        $form = $this->createDeleteForm($orderStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->orderStatusService->delete($orderStatus);
        }
        return $this->redirectToRoute('admin_orderstatus_index');
    }

    /**
     * Creates a form to delete a orderStatus entity.
     *
     * @param OrderStatus $orderStatus The orderStatus entity
     *
     * @return FormInterface
     */
    private function createDeleteForm(OrderStatus $orderStatus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_orderstatus_delete', array('id' => $orderStatus->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
