<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Price;
use OmsBundle\Service\Prices\PriceServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Price controller.
 *
 * @Route("price")
 */
class PriceController extends Controller
{
     private $priceService;
     public function __construct(PriceServiceInterface $priceService)
     {
         $this->priceService=$priceService;
     }

    /**
     * Delete price element from edit Order
     *
     * @Route("/{id}/delete/{cutorderid}", name="price_delete_cutorder",methods={"GET"})
     * @param Price $price
     * @param $cutorderid
     * @return RedirectResponse
     */
    public function deleteFromOrder(Price $price, $cutorderid)
    {
      $this->priceService->delete($price);
        return $this->redirectToRoute('cutorder_edit', ['id' => $cutorderid]);
    }

}
