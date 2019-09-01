<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Product;
use OmsBundle\Service\Base\BaseServiceInterface;
use OmsBundle\Service\Products\ProductServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * @var ProductServiceInterface
     */
    private $productService;

    /**
     * ProductController constructor.
     * @param ProductServiceInterface $productService
     *
     */
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     */
    public function indexAction()
    {
        return $this->render('product/index.html.twig', array(
            'products' => $this->productService->findAllProducts(),
        ));
    }

    /**
     * Creates a new product GET.
     *
     * @Route("/new", name="product_new",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function new()
    {
        return $this->render('product/new.html.twig', array(
            'form' => $this->createForm('OmsBundle\Form\ProductType')->createView(),
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function newProcess(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('OmsBundle\Form\ProductType', $product);
        $form->handleRequest($request);
        $product->setDateAdded(new \DateTime());

        /**
         * @var UploadedFile $file
         */
        $file = $form['pictureFile']->getData();
        if ($file) {
            $product = $this->productService->uploadImage($product, $file);
        }
        $this->productService->save($product);

        return $this->redirectToRoute('product_show', array('id' => $product->getId()));
    }


    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     * @param Product $product
     * @return Response
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $this->createForm('OmsBundle\Form\ProductType', $product)->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function editProcess(Request $request, Product $product)
    {
        $editForm = $this->createForm('OmsBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $editForm['pictureFile']->getData();
            if ($file) {

                $this->productService->removeImage($product);

               $product = $this->productService->uploadImage($product, $file);
            }
            $this->productService->edit($product);
        }
        return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
    }


    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productService->delete($product);
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return FormInterface
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
