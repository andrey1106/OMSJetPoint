<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\OrderStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Orderstatus controller.
 *
 * @Route("admin/orderstatus")
 */
class OrderStatusController extends Controller
{
    /**
     * Lists all orderStatus entities.
     *
     * @Route("/", name="admin_orderstatus_index",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') and is_granted('ROLE_USER')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orderStatuses = $em->getRepository('OmsBundle:OrderStatus')->findAll();

        return $this->render('orderstatus/index.html.twig', array(
            'orderStatuses' => $orderStatuses,
        ));
    }

    /**
     * Creates a new orderStatus entity.
     *
     * @Route("/new", name="admin_orderstatus_new",methods={"GET", "POST"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $orderStatus = new Orderstatus();
        $form = $this->createForm('OmsBundle\Form\OrderStatusType', $orderStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderStatus->setDateAdded(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderStatus);
            $em->flush();

            return $this->redirectToRoute('admin_orderstatus_show', array('id' => $orderStatus->getId()));
        }

        return $this->render('orderstatus/new.html.twig', array(
            'orderStatus' => $orderStatus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a orderStatus entity.
     *
     * @Route("/{id}", name="admin_orderstatus_show",methods={"GET"})
     *
     */
    public function showAction(OrderStatus $orderStatus)
    {
        $deleteForm = $this->createDeleteForm($orderStatus);

        return $this->render('orderstatus/show.html.twig', array(
            'orderStatus' => $orderStatus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing orderStatus entity.
     *
     * @Route("/{id}/edit", name="admin_orderstatus_edit",methods={"GET", "POST"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function editAction(Request $request, OrderStatus $orderStatus)
    {
        $deleteForm = $this->createDeleteForm($orderStatus);
        $editForm = $this->createForm('OmsBundle\Form\OrderStatusType', $orderStatus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_orderstatus_edit', array('id' => $orderStatus->getId()));
        }

        return $this->render('orderstatus/edit.html.twig', array(
            'orderStatus' => $orderStatus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a orderStatus entity.
     *
     * @Route("/{id}", name="admin_orderstatus_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, OrderStatus $orderStatus)
    {
        $form = $this->createDeleteForm($orderStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderStatus);
            $em->flush();
        }

        return $this->redirectToRoute('admin_orderstatus_index');
    }

    /**
     * Creates a form to delete a orderStatus entity.
     *
     * @param OrderStatus $orderStatus The orderStatus entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(OrderStatus $orderStatus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_orderstatus_delete', array('id' => $orderStatus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
