<?php


namespace OmsBundle\Service\Companies;


use OmsBundle\Entity\Company;

interface CompanyServiceInterface
{
    public function save(Company $company);
    public function edit(Company $company);
    public function delete(Company $company);
    public function findOneCompanyByID($id);
    public function findAllCompanies();
}