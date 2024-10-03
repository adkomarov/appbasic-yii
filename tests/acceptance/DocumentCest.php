<?php

#use AcceptanceTester;
use PHPUnit\Framework\Assert;
use app\modules\takedatam\models\Fieldsforms;


use yii\helpers\Url;


class DocumentCest
{
    /**
     * @var \FunctionalTester
     */

    public string $urlRoute = '/specialsection/section/document';

    protected $tester;

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute($this->urlRoute));//'/takedatam/default/paidedu'
    }

    #protected function _before(AcceptanceTester $I)
    #{
    #    Dataforms::deleteAll();
    #}

    protected function _after(AcceptanceTester $I)
    {
    }
    
    public function testDocumentAction(AcceptanceTester $I)
    {
        $I->amOnPage($this->urlRoute);
        //$I->see('Home');
    }

    public function submitValidData(AcceptanceTester $I)
    {
        
        $xpathTextForm1 = '//*[@id="main"]/div/form/div[1]/div[1]/input';
        $xpathTextForm2 = '//*[@id="main"]/div/form/div[4]/div[1]/input';
        $xpathTextForm3 = '//*[@id="main"]/div/form/div[6]/div[1]/input';
        $xpathTextForm4 = '//*[@id="main"]/div/form/div[8]/div[1]/input';
        $xpathTextForm5 = '//*[@id="main"]/div/form/div[10]/div[1]/input';
        $xpathTextForm6 = '//*[@id="main"]/div/form/div[12]/div[1]/input';
        $xpathTextForm7 = '//*[@id="main"]/div/form/div[14]/div[1]/input';
        $xpathTextForm8 = '//*[@id="main"]/div/form/div[16]/div[1]/input';
        $xpathTextForm9 = '//*[@id="main"]/div/form/div[18]/div[1]/input';
        $xpathTextForm10 = '//*[@id="main"]/div/form/div[20]/div[1]/input';
        $xpathTextForm11 = '//*[@id="main"]/div/form/div[22]/div[1]/input';
        $xpathTextForm12 = '//*[@id="main"]/div/form/div[24]/div[1]/input';
        $xpathTextForm13 = '//*[@id="main"]/div/form/div[26]/div[1]/input';
        $xpathTextForms = [
            $xpathTextForm1,
            $xpathTextForm2,
            $xpathTextForm3,
            $xpathTextForm4,
            $xpathTextForm5,
            $xpathTextForm6,
            $xpathTextForm7,
            $xpathTextForm8,
            $xpathTextForm9,
            $xpathTextForm10,
            $xpathTextForm11,
            $xpathTextForm12,
            $xpathTextForm13,
        ];

        $textForm1 = 'textForm1';
        $textForm2 = 'textForm2';
        $textForm3 = 'textForm3';
        $textForm4 = 'textForm4';
        $textForm5 = 'textForm5';
        $textForm6 = 'textForm6';
        $textForm7 = 'textForm7';
        $textForm8 = 'textForm8';
        $textForm9 = 'textForm9';
        $textForm10 = 'textForm10';
        $textForm11 = 'textForm11';
        $textForm12 = 'textForm12';
        $textForm13 = 'textForm13';
        $textForms = [
            $textForm1,
            $textForm2,
            $textForm3,
            $textForm4,
            $textForm5,
            $textForm6,
            $textForm7,
            $textForm8,
            $textForm9,
            $textForm10,
            $textForm11,
            $textForm12,
            $textForm13,
        ];

        $xpathDocForm1 = '//*[@id="File0"]';
        $xpathDocForm2 = '//*[@id="File1"]';
        $xpathDocForm3 = '//*[@id="File2"]';
        $xpathDocForm4 = '//*[@id="File3"]';
        $xpathDocForm5 = '//*[@id="File4"]';
        $xpathDocForm6 = '//*[@id="File5"]';
        $xpathDocForm7 = '//*[@id="File6"]';
        $xpathDocForm8 = '//*[@id="File7"]';
        $xpathDocForm9 = '//*[@id="File8"]';
        $xpathDocForm10 = '//*[@id="File9"]';
        $xpathDocForm11 = '//*[@id="File10"]';
        $xpathDocForm12 = '//*[@id="File11"]';
        $xpathDocForm13 = '//*[@id="File12"]';
        $xpathDocForms = [
            $xpathDocForm1,
            $xpathDocForm2,
            $xpathDocForm3,
            $xpathDocForm4,
            $xpathDocForm5,
            $xpathDocForm6,
            $xpathDocForm7,
            $xpathDocForm8,
            $xpathDocForm9,
            $xpathDocForm10,
            $xpathDocForm11,
            $xpathDocForm12,
            $xpathDocForm13,
        ];

        $testFile1 = 'test_copy_1.png';
        $testFile2 = 'test_copy_2.png'; 
        $testFile3 = 'test_copy_3.png'; 
        $testFile4 = 'test_copy_4.png'; 
        $testFile5 = 'test_copy_5.png'; 
        $testFile6 = 'test_copy_6.png'; 
        $testFile7 = 'test_copy_7.png'; 
        $testFile8 = 'test_copy_8.png'; 
        $testFile9 = 'test_copy_9.png';
        $testFile10 = 'test_copy_10.png'; 
        $testFile11 = 'test_copy_11.png'; 
        $testFile12 = 'test_copy_12.png'; 
        $testFile13 = 'test_copy_13.png';
        $testFiles = [
            $testFile1,
            $testFile2,
            $testFile3,
            $testFile4,
            $testFile5,
            $testFile6,
            $testFile7,
            $testFile8,
            $testFile9,
            $testFile10,
            $testFile11,
            $testFile12,
            $testFile13,
        ];

        $elementButtonAdd1 = '/html/body/main/div/form/div[1]/button';//'button.btn-success[value="11"]';//*[@id="add_row"]
        $elementButtonAdd2 = '/html/body/main/div/form/div[4]/button';//'button.btn-success[value="12"]';/html/body/main/div/form/div[3]/button
        $elementButtonAdd3 = '/html/body/main/div/form/div[6]/button';//'button.btn-success[value="13"]';
        $elementButtonAdd4 = '/html/body/main/div/form/div[8]/button';//'button.btn-success[value="14"]';
        $elementButtonAdd5 = '/html/body/main/div/form/div[10]/button';//'button.btn-success[value="15"]';
        $elementButtonAdd6 = '/html/body/main/div/form/div[12]/button';//'button.btn-success[value="16"]';
        $elementButtonAdd7 = '/html/body/main/div/form/div[14]/button';//'button.btn-success[value="17"]';
        $elementButtonAdd8 = '/html/body/main/div/form/div[16]/button';//'button.btn-success[value="18"]';
        $elementButtonAdd9 = '/html/body/main/div/form/div[18]/button';//'button.btn-success[value="19"]';
        $elementButtonAdd10 ='/html/body/main/div/form/div[20]/button';// 'button.btn-success[value="20"]';
        $elementButtonAdd11 ='/html/body/main/div/form/div[22]/button';// 'button.btn-success[value="21"]';
        $elementButtonAdd12 ='/html/body/main/div/form/div[24]/button';// 'button.btn-success[value="22"]';
        $elementButtonAdd13 ='/html/body/main/div/form/div[26]/button';// 'button.btn-success[value="23"]';
        $arrayElementsButtonsAdd = [
            $elementButtonAdd1,
            $elementButtonAdd2,
            $elementButtonAdd3,
            $elementButtonAdd4,
            $elementButtonAdd5,
            $elementButtonAdd6,
            $elementButtonAdd7,
            $elementButtonAdd8,
            $elementButtonAdd9,
            $elementButtonAdd10,
            $elementButtonAdd11,
            $elementButtonAdd12,
            $elementButtonAdd13,
        ];

        $elementButtonSave = '#main > div > form > div.form-group > button:nth-child(1)';
        

        $I->maximizeWindow();
        //$I->scrollToElementIfNotVisible($elementButtonAdd1);//$I->scrollToElementIfNotVisibleXpath($elementButtonAdd1);
        //$I->waitForElementClickable($elementButtonAdd1);
        //$I->click($elementButtonAdd1);//$I->click(['xpath' => $elementButtonAdd1]);
        //$I->scrollToElementIfNotVisible($elementButtonAdd2);//$I->scrollToElementIfNotVisibleXpath($elementButtonAdd2);
        //$I->waitForElementClickable($elementButtonAdd2);
        //$I->click($elementButtonAdd2);//$I->click($buttons[1]);//$I->click(['xpath' => $elementButtonAdd2]);
        //$I->scrollTo('button.btn-success[value="13"]');//$I->scrollToElementIfNotVisibleXpath($elementButtonAdd3);
        //$I->click('button.btn-success[value="13"]');//$I->click($buttons[2]);//$I->click(['xpath' => $elementButtonAdd3]);
        //$I->scrollTo('button.btn-success[value="14"]');//$I->scrollToElementIfNotVisibleXpath($elementButtonAdd4);
        //$I->click('button.btn-success[value="14"]');//$I->click($buttons[3]);$I->click(['xpath' => $elementButtonAdd4]);
        $I->wait(1);
        
        for ($i = 0; $i < count($arrayElementsButtonsAdd); $i++) {

            $button = $arrayElementsButtonsAdd[$i];
            //$I->waitForElementVisible($button, 10);

            // Ожидание, пока кнопка не станет кликабельной
            //$I->waitForElementClickable($button, 10);

            // Прокрутка до кнопки
            //$I->executeJS('document.evaluate("' . $button . '", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue.scrollIntoView();');
            $I->scrollToElementIfNotVisibleXpath($button);
                    //$I->waitForElementClickable($button);
            $I->click($button);
            $I->wait(1);
        }

        for ($i = 0; $i < count($xpathTextForms); $i++) {
            $oneOfXpathTextForms = $xpathTextForms[$i];
            $oneOftextForms = $textForms[$i];
        
            $I->scrollToElementIfNotVisibleXpath($oneOfXpathTextForms);
            $I->wait(1);
            $I->fillField(['xpath' => $oneOfXpathTextForms], $oneOftextForms);
            $I->wait(1);
        }

        for ($i = 0; $i < count($xpathDocForms); $i++) {
            $oneOfXpathDocForms = $xpathDocForms[$i];
            $oneOfTestFiles = $testFiles[$i];
        
            $I->scrollToElementIfNotVisibleXpath($oneOfXpathDocForms);
            $I->wait(1);
            $I->attachFile(['xpath' => $oneOfXpathDocForms], $oneOfTestFiles);
            $I->wait(1);
        }
        
        $I->scrollToElementIfNotVisible($elementButtonSave);
        $I->waitForElementClickable($elementButtonSave);
        $I->click($elementButtonSave);
        


        //*[@id="main"]/div/form/div[1]/div[1]/input
        //*[@id="main"]/div/form/div[24]/div[1]/input
        //*[@id="main"]/div/form/div[26]/div[1]/input
        //*[@id="File0"]
        //*[@id="File12"]
        /*
        $xpathTextSampleContract = '//*[@id="main"]/div/form/div[1]/div[1]/input';
        $xpathDocSampleContract = '//*[@id="File0"]';

        $xpathTextApprovalDocument = '//*[@id="main"]/div/form/div[3]/div[1]/input';
        $xpathDocApprovalDocument  = '//*[@id="File1"]';

        $xpathTextDeliveryProcedure = '//*[@id="main"]/div/form/div[5]/div[1]/input';
        $xpathDocDeliveryProcedure = '//*[@id="File2"]';

        $xpathTextEstablishmentDocument = '//*[@id="main"]/div/form/div[7]/div[1]/input';
        $xpathDocEstablishmentDocument = '//*[@id="File3"]';
        */
        /*
        $I->amOnPage($this->urlRoute);
        $buttons = $I->grabMultiple('button#add_row');
        $I->click(['css' => 'button#add_row:nth-of-type(1)']);

        $I->fillField(['xpath' => '//*[@id="main"]/div/form/div[1]/div[1]/input'], 'php-webdriver');
        $I->attachFile(['xpath' => '//*[@id="File0"]'], 'test.png');

        //$I->fillField(['xpath' => '//*[@id="main"]/div/form/div[1]/div[1]/input'], 'php-webdriver');
        //$I->attachFile(['xpath' => '//*[@id="File0"]'], 'test.png');

        

        $elementSelector = '#main > div > form > div.form-group > button';

        $I->scrollToElementIfNotVisible($elementSelector);
        $I->click($elementSelector);

        $I->seeInField(['xpath' => '//*[@id="main"]/div/form/div[1]/div[1]/input'],'php-webdriver');
        */
        /*
        //*[@id="main"]/div/form/div[1]/div[1]/div[1]/a
        $actualValue = $I->grabValueFrom(['xpath' => '//*[@id="main"]/div/form/div[1]/div[1]/div[1]/a']);
        $idDoc = Fieldsforms::findOne(11);
        var_dump($actualValue);
        $expected = 'http://127.0.0.1:9000/testbucket/ustav'.$idDoc;
        Assert::assertEquals($actualValue, $expected);
        */

    }
    //*[@id="delrow"]
    /*
    public function deleteData(AcceptanceTester $I)
    {
        $I->click(['xpath' => '//*[@id="delrow"]']);
        $I->acceptPopup();
        $I->dontSeeElement(['xpath'=>'//*[@id="main"]/div/form/div[1]/div[1]/label']);
    }
    */
}