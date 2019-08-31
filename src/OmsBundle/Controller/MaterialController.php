<?php

namespace OmsBundle\Controller;

use OmsBundle\Entity\Material;
use OmsBundle\Service\Materials\MaterialServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Material controller.
 *
 * @Route("material")
 */
class MaterialController extends Controller
{
    private $materialService;

    public function __construct(MaterialServiceInterface $materialService)
    {
        $this->materialService = $materialService;
    }

    /**
     * Lists all material entities.
     *
     * @Route("/", name="material_index",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     */
    public function indexAction()
    {
        return $this->render('material/index.html.twig', array(
            'materials' => $this->materialService->findAllMaterials(),
        ));
    }

    /**
     * Creates a new material GET.
     *
     * @Route("/new", name="material_new",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function new()
    {
        return $this->render('material/new.html.twig', array(
            'form' => $this->createForm('OmsBundle\Form\MaterialType')->createView(),
        ));
    }

    /**
     * Creates a new material POST.
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
        $material = new Material();
        $form = $this->createForm('OmsBundle\Form\MaterialType', $material);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $material->setDateAdded(new \DateTime());
            $this->materialService->save($material);
        }
        return $this->redirectToRoute('material_show', array('id' => $material->getId()));
    }

    /**
     * Finds and displays a material entity.
     *
     * @Route("/{id}", name="material_show",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_GUEST')")
     * @param Material $material
     * @return Response
     */
    public function showAction(Material $material)
    {
        $deleteForm = $this->createDeleteForm($material);

        return $this->render('material/show.html.twig', array(
            'material' => $material,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing material entity.
     *
     * @Route("/{id}/edit", name="material_edit",methods={"GET"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Material $material
     * @return Response
     */
    public function edit(Material $material)
    {
        return $this->render('material/edit.html.twig', array(
            'material' => $material,
            'edit_form' => $this->createForm('OmsBundle\Form\MaterialType', $material)->createView(),
            'delete_form' => $this->createDeleteForm($material)->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing material entity.
     *
     * @Route("/{id}/edit", methods={"POST"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param Material $material
     * @return RedirectResponse
     */
    public function editProcess(Request $request, Material $material)
    {
        $editForm = $this->createForm('OmsBundle\Form\MaterialType', $material);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->materialService->edit($material);
        }
        return $this->redirectToRoute('material_edit', array('id' => $material->getId()));
    }

    /**
     * Deletes a material entity.
     *
     * @Route("/{id}", name="material_delete",methods={"DELETE"})
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     * @param Request $request
     * @param Material $material
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Material $material)
    {
        $form = $this->createDeleteForm($material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $this->materialService->delete($material);
        }

        return $this->redirectToRoute('material_index');
    }

    /**
     * Creates a form to delete a material entity.
     *
     * @param Material $material The material entity
     *
     * @return FormInterface
     */
    private function createDeleteForm(Material $material)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('material_delete', array('id' => $material->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
