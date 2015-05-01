<?php

namespace Shakyamouni\UserBundle\Tests\Functional;

use Shakyamouni\SiteBundle\Tests\Functional\MinkTestCaseBase;

class UserTest extends MinkTestCaseBase
{
    public static function getDataDir($dir)
    {
        return dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'Fixtures/Selenium' . DIRECTORY_SEPARATOR . $dir;
    }

    public function executePaymentForm($filename)
    {
        $data = json_decode(file_get_contents($filename));

        foreach ($data->search as $search) {
            $page = $this->browse($search->url);
            $page->fillField('shakyamouni_userbundle_subscriptioneventtype_firstname', $search->firstname);
            $page->fillField('shakyamouni_userbundle_subscriptioneventtype_lastname', $search->lastname);
            $page->fillField('shakyamouni_userbundle_subscriptioneventtype_cellphone', $search->cellphone);
            $page->fillField('shakyamouni_userbundle_subscriptioneventtype_email', $search->email);
            $page->selectFieldOption('shakyamouni_userbundle_subscriptioneventtype_price', $search->price);
            $page->fillField('shakyamouni_userbundle_subscriptioneventtype_additionnalInformation', $search->adinfo);
            $this->iCheckTheRadioButtonWithValue($search->element, $search->knowledge);
            $optin = $page->find('xpath',$this->session->getSelectorsHandler()->selectorToXpath('xpath', '//*[@id="shakyamouni_userbundle_subscriptioneventtype_isOptin"]'));
            if (true == $search->optin) {
                $optin->check();
            }
            $page->pressButton('Passer au paiement');
            $this->session->wait('8000');
            $login = $page->find('xpath',$this->session->getSelectorsHandler()->selectorToXpath('xpath', '//*[@id="loadLogin"]'));
            $login->click();
            $page->fillField('login_email', 'jp.saulnier11@gmail.com');
            $page->fillField('login_password', 'shakyamouni@2008');
            $page->pressButton('Connexion');
            
        }
    }

    public function execute($dir, $function)
    {
        $dataDir = self::getDataDir($dir);
        $dataDirFiles = scanDir($dataDir);

        foreach ($dataDirFiles as $filename) {
            if ('.' !== $filename && '..' !== $filename) {
                $this->$function($dataDir . DIRECTORY_SEPARATOR . $filename);
            }
        }
    }
    
    public function testFillFormPage()
    {
        $this->execute('Payment', 'executePaymentForm');
    }
}