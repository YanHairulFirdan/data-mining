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
    public function splitData($datasets)
    {
        // shuffle($dataset);
        $splitedData = [
            0 => [],
            1 => []
        ];
        $remainData = [];
        $data = [];
        foreach ($datasets as $key => $dataset) {
            if (count($dataset) % $this->kFold == 0) {
                $numberofitem = count($dataset) / $this->kFold;
                $splitedData[$key] = $this->pushData($dataset, $numberofitem);
            } else {
                $remain = count($dataset) % $this->kFold;
                $newItemCount = count($dataset) - $remain; //109-4 = 105
                $splitedData[$key] = $this->pushData($dataset, $newItemCount / $this->kFold);
                $counter = $newItemCount;
                for ($i = 0; $i < $remain; $i++) {
                    array_push($remainData, $dataset[$counter]);
                    $counter++;
                }
            }
        }


        for ($i = 0; $i < $this->kFold; $i++) {
            $data[$i] = array_merge($splitedData[0][$i], $splitedData[1][$i]);
            if ($i < count($remainData)) {
                array_push($data[$i], $remainData[$i]);
            }
        }
        return $data;
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
