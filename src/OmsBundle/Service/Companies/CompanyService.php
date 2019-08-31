<?php


namespace OmsBundle\Service\Companies;


use Doctrine\ORM\ORMException;
use OmsBundle\Entity\Company;
use OmsBundle\Repository\CompanyRepository;

class CompanyService implements CompanyServiceInterface
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository=$companyRepository;
    }

    /**
     * @param Company $company
     * @return ORMException|\Exception|void
     */
    public function save(Company $company)
    {
        try {
            return $this->companyRepository->insert($company);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param Company $company
     * @return ORMException|\Exception|void
     */
    public function edit(Company $company)
    {
        try {
            return $this->companyRepository->update($company);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param Company $company
     * @return ORMException|\Exception|void
     */
    public function delete(Company $company)
    {
        //TODO Remove Contacts first
        try {
            return $this->companyRepository->remove($company);
        } catch (ORMException $e) {
            return $e;
        }
    }

    /**
     * @param $id
     * @return object|null
     */
    public function findOneCompanyByID($id)
    {
        return $this->companyRepository->find($id);
    }

    /**
     * @return array
     */
    public function findAllCompanies()
    {
        return $this->companyRepository->findAll();
    }
}