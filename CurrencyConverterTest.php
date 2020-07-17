<?php
//use Calculator;
require 'CurrencyConvert.php';
use PHPunit\Framework\TestCase;
/*
    {"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
{"bin":"41417360","amount":"130.00","currency":"USD"}
{"bin":"4745030","amount":"2000.00","currency":"GBP"}
*/

class CurrencyConverterTest extends TestCase
{
    private $currencyConvert;
 
    public function __construct($name = null, array $data = [], $dataName = ''){

        parent::__construct();
        $this->currencyConvert = new CurrencyConvert($name);
    }

    
 
     
    public function testBin()
    {
         $this->assertEquals('DK', $this->currencyConvert->getBin('45717360'));
         $this->assertEquals('UK', $this->currencyConvert->getBin('45717360'));
        
    }

    public function testRate()
    {
         $this->assertEquals('0.43805852461889', $this->currencyConvert->getRate('EUR'));
         $this->assertEquals('0.3242343243434', $this->currencyConvert->getRate('USD'));
        
    }
 
}
