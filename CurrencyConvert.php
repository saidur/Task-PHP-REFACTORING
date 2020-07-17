<?php
class CurrencyConvert 
{
    
    
    public function __construct ($fileName=''){

        if ($fileName != ''){

            $this->main($fileName);
        }    
    }
        
    
    public function main($fileName){

        
        foreach (explode("\n", file_get_contents($fileName)) as $jsonString) {

            $row = json_decode($jsonString, true);
            
            $bin = $row['bin'];
            $amount = $row['amount'];
            $currency = $row['currency'];
            $alpha2 = $this->getBin($bin);
            if ($alpha2 == false)
                die ('error');
            $isEu = $this->isEu($alpha2);
            $rate = $this->getRate($currency);
            $amntFixed = $this->getAmount($currency,$rate,$amount);
            echo $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);
            print "\n";       
        
        }

    }

    public function getBin($bin)
        {
            try {
                    $binResults = file_get_contents('https://lookup.binlist.net/' .$bin);
                    if (!$binResults)
                        return false;
                    $r = json_decode($binResults);
                    return $r->country->alpha2;
        
            }catch(Error $e){
                    echo "Error caught: " . $e->getMessage();
                    return false;
            }
            
           
        }


        public function getRate($currency){

            try {
                $rate = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'][$currency];
                return $rate;
            }catch(Error $e){
                echo "Error caught: " . $e->getMessage();
                return false;
            }    
        }

        public function getAmount($currency,$rate,$amount){

            if ($currency == 'EUR' or $rate == 0) {
                $amntFixed = $amount;
            }
            
            try {
                if ($currency != 'EUR' or $rate > 0) {
                    $amntFixed = $amount/$rate;
                }
            }catch(Error $e){
                echo "Error caught: " . $e->getMessage();
                return false;
            }

            return $amntFixed;
        
            

        }

        function isEu($c) {
            $result = false;
            switch($c) {
                case 'AT':
                case 'BE':
                case 'BG':
                case 'CY':
                case 'CZ':
                case 'DE':
                case 'DK':
                case 'EE':
                case 'ES':
                case 'FI':
                case 'FR':
                case 'GR':
                case 'HR':
                case 'HU':
                case 'IE':
                case 'IT':
                case 'LT':
                case 'LU':
                case 'LV':
                case 'MT':
                case 'NL':
                case 'PO':
                case 'PT':
                case 'RO':
                case 'SE':
                case 'SI':
                case 'SK':
                    $result = 'yes';
                    return $result;
                default:
                    $result = 'no';
            }
            return $result;
        }  
    
    
    public function testTwoNumbersAreAdded()
    {
        $adder = new NumberAdder(1, 2);
        $result = $adder->add();

        $this->assertEquals(3, $result);
    }
}


$file = (isset($argv[1])) ? $argv[1] : null;

$cc = new CurrencyConvert($file);


