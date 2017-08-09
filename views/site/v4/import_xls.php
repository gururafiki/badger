<?php
require_once 'Classes/PHPExcel/IOFactory.php';
require "db1.php";
class chunkReadFilter implements PHPExcel_Reader_IReadFilter
{
private $_startRow = 0;
private $_endRow = 0;

function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

    function get_type($name){
        $find_val = 'JSY';
        $pos = strpos($name, $find_val);//поиск слова UAH в колонке price
        if ($pos === false) {//если UAH нету в строке
            $find_val = 'TEE';
            $pos = strpos($name, $find_val);
            if ($pos === false) {//если UAH нету в строке
                $find_val = 'POLO';
                $pos = strpos($name, $find_val);
                if ($pos === false) {//если UAH нету в строке
                    $find_val = 'SHO';
                    $pos = strpos($name, $find_val);
                        if ($pos === false) {//если UAH нету в строке
                            $find_val = 'SHTS';
                            $pos = strpos($name, $find_val);
                            if ($pos === false) {//если UAH нету в строке
                                $find_val = 'SHORTS';
                                $pos = strpos($name, $find_val);
                                if ($pos === false) {//если UAH нету в строке
                                    $find_val = 'PAD';
                                    $pos = strpos($name, $find_val);
                                    if ($pos === false) {//если UAH нету в строке
                                        $find_val = 'JKT';
                                        $pos = strpos($name, $find_val);
                                        if ($pos === false) {//если UAH нету в строке
                                            $find_val = 'TOP';
                                            $pos = strpos($name, $find_val);
                                            if ($pos === false) {
                                                $find_val = 'SUIT';
                                                $pos = strpos($name, $find_val);
                                                if ($pos === false) {
                                                    $find_val = 'VEST';
                                                    $pos = strpos($name, $find_val);
                                                    if ($pos === false) {
                                                        $find_val = 'CAP';
                                                        $pos = strpos($name, $find_val);
                                                        if ($pos === false) {
                                                            $find_val = 'PNT';
                                                            $pos = strpos($name, $find_val);
                                                            if ($pos === false) {
                                                                $find_val = 'GLOVES';
                                                                $pos = strpos($name, $find_val);
                                                                if ($pos === false) {
                                                                    $find_val = 'GK';
                                                                    $pos = strpos($name, $find_val);
                                                                    if ($pos === false) {
                                                                        $type='Other';
                                                                    }
                                                                    else{
                                                                        $type='Gloves';
                                                                    }
                                                                }
                                                                else{
                                                                    $type='Gloves';
                                                                }
                                                            }
                                                            else{
                                                                $type='Pants';
                                                            }
                                                        }
                                                        else{
                                                            $type='Caps';
                                                        }
                                                    }
                                                    else{
                                                        $type='Vests';
                                                    }
                                                }
                                                else{
                                                    $type='Suits';
                                                }
                                            }
                                            else{
                                                $type='Jackets';
                                            }
                                        }
                                        else{
                                            $type='Jackets';
                                        }
                                    }
                                    else{
                                        $type='Jackets';
                                    }
                                }
                                else{
                                    $type='Shorts';
                                }
                            }
                            else{
                                $type='Shorts';
                            }
                    }
                    else{
                        $type='Shorts';
                    }
                }
                else{
                    $type='Tshirts';
                }
            }
            else{
                $type='Tshirts';
            }
        }
        else {
            $type='Tshirts';
        }
         return $type;
    }

    function photo_check($i,$article){
        $photo_url='http://demandware.edgesuite.net/sits_pod14-adidas/dw/image/v2/aagl_prd/on/demandware.static/-/Sites-adidas-products/default/dw5d486956/zoom/'.$article.'_0'.$i.'_standard.jpg';
        $response_code = get_http_response_code($photo_url);
        if($response_code==200){
            return $photo_url;
        }
        else{
            return 'No photo yet';
        }
    }

public function setRows($startRow, $chunkSize) {
    $this->_startRow    = $startRow;
    $this->_endRow      = $startRow + $chunkSize;
}

public function readCell($column, $row, $worksheetName = '') {
    if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
        return true;
    }
    return false;
}
}

session_start();

if ($_SESSION['startRow']) $startRow = $_SESSION['startRow'];
else $startRow = 10;

    $inputFileType = 'Excel5';
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $chunkSize = 20;
    $chunkFilter = new chunkReadFilter();

    while ($startRow <= 65000) {
     $chunkFilter->setRows($startRow,$chunkSize);
     $objReader->setReadFilter($chunkFilter);
     $objReader->setReadDataOnly(true);
     $objPHPExcel = $objReader->load('xls12.xls');
     foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
     for ($row = $_startRow; $row <= $_endRow; ++$row) {
                if($worksheet->getCellByColumnAndRow(1, $row)->getValue()!='' ) {
                    $product=R::findOne('base','article = ? AND size_ru = ? AND size = ?',array(trim($worksheet->getCellByColumnAndRow(1, $row)->getValue()),$worksheet->getCellByColumnAndRow(5, $row)->getValue(),$worksheet->getCellByColumnAndRow(4, $row)->getValue()));
                    if(!isset($product)){
                        $product = R::dispense('base');
                        $product_gen = R::findOne('unique','article = ?',array(trim($worksheet->getCellByColumnAndRow(1, $row)->getValue())));
                        if(isset($product_gen)){
                            $product->photo=$product_gen->photo_1;
                        }
                        else{
                            $product_gen=R::dispense('unique');
                            $article=trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                            $product_gen->article=$article;
                            R::store($product_gen);
                            $i=1;
                            $photo='smthng';
                            while($photo!='No photo yet'){
                                $photo=photo_check($i,$article);
                                $query="UPDATE `unique` SET `unique`.`photo_".$i."`='".$photo."' WHERE `unique`.`article` = '".$article."'";
                                R::exec($query);
                                $i++;
                            }  
                            $product->photo = R::findOne('unique','article = ?',array($article))->photo_1;
                        }
                        $product->article = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                        $product->name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $product->type= get_type($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $product->price_buy = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $product->price_sell = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $product->size = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $product->size_ru = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $product->count = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $find_val = '|';
                        $pos = strpos($product->size_ru, $find_val);
                        $find_val1 = '-';
                        $pos1 = strpos($product->size_ru, $find_val1);
                        if($product->type=='Other' && $product->size_ru>=15 && $product->size_ru<60 && $pos === false && $pos1 === false){
                            $product->type='Shoes';
                        }
                        $category_ru= R::FindOne('category','name = ? AND type = ? ',array($worksheet->getCellByColumnAndRow(5, $row)->getValue(), $product->type));
                        $category= R::FindOne('category','name = ? AND type = ? ',array($worksheet->getCellByColumnAndRow(4, $row)->getValue(), $product->type));
                        if(isset($category_ru)){
                            $product->category_id=$category_ru->id;
                            $category_ru->need = 1;
                            R::store($category_ru);
                        }
                        elseif(isset($category)){
                            $product->category_id=$category->id;
                            $category->need = 2;
                            R::store($category);
                        }
                        else{
                            $product->category_id=6;
                        }
                        R::store($product);
                    }
                    else{
                        $product->count = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        R::store($product);
                    }
                }
            };
        }
     $startRow += $chunkSize;
     $_SESSION['startRow'] = $startRow; 

    unset($objReader); 

    unset($objPHPExcel);

    }

    echo "The End";
    unset($_SESSION['startRow']);
?>