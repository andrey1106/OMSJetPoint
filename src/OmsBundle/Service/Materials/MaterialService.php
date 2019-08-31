<?php


namespace OmsBundle\Service\Materials;


use Doctrine\ORM\ORMException;
use OmsBundle\Entity\Material;
use OmsBundle\Repository\MaterialRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class MaterialService implements MaterialServiceInterface
{
    /**
     * @var MaterialRepository
     */
    private $materialRepository;
    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository=$materialRepository;
    }

    /**
     * @param Material $material
     * @return ORMException|\Exception|void
     */
    public function save(Material $material)
    {
        try {
            return $this->materialRepository->insert($material);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param Material $material
     * @return ORMException|\Exception|void
     */
    public function edit(Material $material)
    {
        try {
            return $this->materialRepository->update($material);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param Material $material
     * @return ORMException|\Exception|void
     *
     */
    public function delete(Material $material)
    {
        try {
            return $this->materialRepository->remove($material);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @return array
     */
    public function findAllMaterials()
    {
        return $this->materialRepository->findAll();
    }
}