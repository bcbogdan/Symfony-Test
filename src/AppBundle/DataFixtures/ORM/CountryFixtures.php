<?php
namespace AppBundle\DataFixtures\ORM;
use AppBundle\Entity\Country;
class CountryFixtures extends AbstractDataFixture
{
    private $countries = array(
        'en' => array('england', 'GBP'),
        'es' => array('spain', 'EUR'),
        'fr' => array('france', 'EUR'),
        'it' => array('italy', 'EUR'),
        'ro' => array('romania', 'RON'),
        'tn' => array('tunisia', 'TND'),
    );
    protected function createAndPersistData()
    {
        $countryCount = 0;
        foreach ($this->countries as $code => $country) {
            $countryCount++;
            $countryEntity = new Country();
            $countryEntity->setCode($code)
                ->setName($country[0])
                ->setCurrency($country[1]);
            $this->setReference(sprintf('country_%s', $countryCount), $countryEntity);
            $this->manager->persist($countryEntity);
        }
    }
    public function getOrder()
    {
        return 1;
    }
}