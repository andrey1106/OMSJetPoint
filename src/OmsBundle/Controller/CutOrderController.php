<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\CutOrder;
use OmsBundle\Entity\Price;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Cutorder controller.
 *
 * @Route("cutorder")
 */
class CutOrderController extends Controller
{
    /**
     * Lists all cutOrder entities.
     *
     * @Route("/", name="cutorder_index",methods={"GET"})
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cutOrders = $em->getRepository('OmsBundle:CutOrder')->findAll();

        return $this->render('cutorder/index.html.twig', array(
            'cutOrders' => $cutOrders,
        ));
    }

    /**
     * Creates a new cutOrder entity.
     *
     * @Route("/new", name="cutorder_new",methods={"GET", "POST"})
     *
     */
    public function newAction(Request $request)
    {
        $cutOrder = new Cutorder();
       //TODO Remove Static Test Code
        $price1=new Price();
        $cutOrder->getPrices()->add($price1);
        $price2=new Price();
        $cutOrder->getPrices()->add($price2);
        //TODO END TestCode
        $form = $this->createForm('OmsBundle\Form\CutOrderType', $cutOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cutOrder->setTotalNoVAT(30);
            $cutOrder->setDateAdded(new \DateTime());
            //$em = $this->getDoctrine()->getManager();
            //$em->persist($cutOrder);
            //$em->flush();

            return $this->redirectToRoute('cutorder_show', array('id' => $cutOrder->getId()));
        }

        return $this->render('cutorder/new.html.twig', array(
            'cutOrder' => $cutOrder,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cutOrder entity.
     *
     * @Route("/{id}", name="cutorder_show",methods={"GET"})
     *
     */
    public function showAction(CutOrder $cutOrder)
    {
        $deleteForm = $this->createDeleteForm($cutOrder);

        return $this->render('cutorder/show.html.twig', array(
            'cutOrder' => $cutOrder,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cutOrder entity.
     *
     * @Route("/{id}/edit", name="cutorder_edit",methods={"GET", "POST"})
     *
     */
    public function editAction(Request $request, CutOrder $cutOrder)
    {
        $deleteForm = $this->createDeleteForm($cutOrder);
        $editForm = $this->createForm('OmsBundle\Form\CutOrderType', $cutOrder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cutorder_edit', array('id' => $cutOrder->getId()));
        }

        return $this->render('cutorder/edit.html.twig', array(
            'cutOrder' => $cutOrder,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cutOrder entity.
     *
     * @Route("/{id}", name="cutorder_delete",methods={"DELETE"})
     *
     */
    public function deleteAction(Request $request, CutOrder $cutOrder)
    {
        $form = $this->createDeleteForm($cutOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cutOrder);
            $em->flush();
        }

        return $this->redirectToRoute('cutorder_index');
    }

    /**
     * Creates a form to delete a cutOrder entity.
     *
     * @param CutOrder $cutOrder The cutOrder entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(CutOrder $cutOrder)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cutorder_delete', array('id' => $cutOrder->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
