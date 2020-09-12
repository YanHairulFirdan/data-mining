<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrossValidation
{
    public $kFold;

    public function __construct()
    {
    }

    function setKfold($k)
    {
        $this->kFold = $k;
        echo gettype($k);
        // die;
    }
    public function splitData($dataset)
    {
        // shuffle($dataset);
        $splitedData = [];
        if (count($dataset) % $this->kFold == 0) {
            // echo "it is even division" . "<br>";
            echo count($dataset) / $this->kFold . "<br>";
            $numberofitem = count($dataset) / $this->kFold;
            $splitedData = $this->pushData($dataset, $numberofitem);
        } else {
            $remain = count($dataset) % $this->kFold;
            $newItemCount = count($dataset) - $remain;
            $splitedData = $this->pushData($dataset, $newItemCount / $this->kFold);
            $counter = $newItemCount - 1;
            for ($i = 0; $i < $remain; $i++) {
                array_push($splitedData[$i], $dataset[$counter]);
                $counter++;
            }
        }
        return $splitedData;
    }

    private function pushData($dataset, $numberofitems)
    {
        $counter = 0;
        $storeTemp = [];
        $splitedData = [];
        for ($i = 0; $i < $this->kFold; $i++) {
            for ($j = 0; $j < $numberofitems; $j++) {
                array_push($storeTemp, $dataset[$counter]);
                $counter++;
            }
            array_push($splitedData, $storeTemp);
            $storeTemp = [];
        }
        return $splitedData;
    }

    public function echoFunc()
    {
        echo "loaded :)";
    }
}
