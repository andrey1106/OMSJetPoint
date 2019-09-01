<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\CutOrder;
use OmsBundle\Entity\Price;
use OmsBundle\Service\CutOrders\CutOrderServiceInterface;
use OmsBundle\Service\Prices\PriceServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\fromJSON;


/**
 * Cutorder controller.
 *
 * @Route("cutorder")
 */
class CutOrderController extends Controller
{
    private $cutOrderService;
    private $priceService;

    public function __construct(CutOrderServiceInterface $cutOrderService,PriceServiceInterface $priceService)
    {
        $this->cutOrderService = $cutOrderService;
        $this->priceService=$priceService;
    }

    /**
     * Lists all cutOrder entities.
     *
     * @Route("/", name="cutorder_index",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     */
    public function indexAction()
    {
        return $this->render('cutorder/index.html.twig', array(
            'cutOrders' => $this->cutOrderService->findAllOrders(),
        ));
    }

    /**
     * Creates a new cutOrder entity.
     *
     * @Route("/new", name="cutorder_new",methods={"GET", "POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        $cutOrder = new Cutorder();
        $form = $this->createForm('OmsBundle\Form\CutOrderType', $cutOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cutOrder->setDateAdded(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $formData = $form->getData()->getPrices();
            $totalPriceNoVAT = 0;
            foreach ($formData as $recordPrice) {
                $recordPrice->setOrder($cutOrder);
                $recordPrice=$this->priceService->calcPrice($recordPrice);
                $totalPriceNoVAT = $totalPriceNoVAT + $recordPrice->getPrice();
                $em->persist($recordPrice);
            }
            $cutOrder->setTotalNoVAT($totalPriceNoVAT);
            $em->persist($cutOrder);
            $em->flush();
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
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     * @param CutOrder $cutOrder
     * @return Response
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
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param CutOrder $cutOrder
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, CutOrder $cutOrder)
    {
        $deleteForm = $this->createDeleteForm($cutOrder);
        $editForm = $this->createForm('OmsBundle\Form\CutOrderType', $cutOrder);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $editFormData = $editForm->getData()->getPrices();
            $totalPriceNoVAT = 0;
            foreach ($editFormData as $recordPrice) {
                $recordPrice->setOrder($cutOrder);
                $recordPrice=$this->priceService->calcPrice($recordPrice);
                $totalPriceNoVAT = $totalPriceNoVAT + $recordPrice->getPrice();
                $em->persist($recordPrice);
            }
            $cutOrder->setTotalNoVAT($totalPriceNoVAT);
            $em->persist($cutOrder);
            $em->flush();

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
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     * @param Request $request
     * @param CutOrder $cutOrder
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, CutOrder $cutOrder)
    {
        $form = $this->createDeleteForm($cutOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($cutOrder->getPrices() as $price){
                $em->remove($price);
            }
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
            ->getForm();
    }
}
