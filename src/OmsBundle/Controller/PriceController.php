<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Price;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Price controller.
 *
 * @Route("price")
 */
class PriceController extends Controller
{
    /**
     * Lists all price entities.
     *
     * @Route("/", name="price_index",methods={"GET"})
     *
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prices = $em->getRepository('OmsBundle:Price')->findAll();

        return $this->render('price/index.html.twig', array(
            'prices' => $prices,
        ));
    }

    /**
     * Creates a new price entity.
     *
     * @Route("/new", name="price_new",methods={"GET", "POST"})
     *
     */
    public function newAction(Request $request)
    {
        $price = new Price();
        $form = $this->createForm('OmsBundle\Form\PriceType', $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($price);
            $em->flush();

            return $this->redirectToRoute('price_show', array('id' => $price->getId()));
        }

        return $this->render('price/new.html.twig', array(
            'price' => $price,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a price entity.
     *
     * @Route("/{id}", name="price_show",methods={"GET"})
     *
     */
    public function showAction(Price $price)
    {
        $deleteForm = $this->createDeleteForm($price);

        return $this->render('price/show.html.twig', array(
            'price' => $price,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing price entity.
     *
     * @Route("/{id}/edit", name="price_edit",methods={"GET", "POST"})
     *
     */
    public function editAction(Request $request, Price $price)
    {
        $deleteForm = $this->createDeleteForm($price);
        $editForm = $this->createForm('OmsBundle\Form\PriceType', $price);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('price_edit', array('id' => $price->getId()));
        }

        return $this->render('price/edit.html.twig', array(
            'price' => $price,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a price entity.
     *
     * @Route("/{id}", name="price_delete",methods={"DELETE"})
     *
     */
    public function deleteAction(Request $request, Price $price)
    {
        $form = $this->createDeleteForm($price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($price);
            $em->flush();
        }

        return $this->redirectToRoute('price_index');
    }

    /**
     * Creates a form to delete a price entity.
     *
     * @param Price $price The price entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Price $price)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('price_delete', array('id' => $price->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Delete price element from edit Order
     *
     * @Route("/{id}/delete/{cutorderid}", name="price_delete_cutorder",methods={"GET"})
     *
     */
    public function deleteFromOrder(Request $request, Price $price, $cutorderid)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($price);
            $em->flush();


        return $this->redirectToRoute('cutorder_edit',['id' => $cutorderid]);
    }

}
