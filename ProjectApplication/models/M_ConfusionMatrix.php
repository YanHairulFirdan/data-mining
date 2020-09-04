<?php
class M_ConfusionMatrix extends CI_Model
{
    public function splitData()
    {
        $dataSet = $this->db->get('posterior')->result_array();
        $dataSplitted = [];

        for ($i = 0; $i < $this->session->userdata('kfold'); $i++) {
            foreach ($dataSet as $key => $data) {

                if ($data['iteration'] == $i) {
                    if (!isset($dataSplitted[$i])) {
                        $dataSplitted[$i] = [];
                    }
                    array_push($dataSplitted[$i], $data);
                }
            }
        }

        return $dataSplitted;
    }


    public function performance()
    {
        $dataset = $this->splitData();
        $tp = $tn = $fp = $fn = 0;
        $count = 0;
        $performances = [];

        foreach ($dataset as $keys => $tuples) {
            // echo "performance dari k-" . $key . br();
            foreach ($tuples as $key => $data) {

                if ($data['real_result'] == 'success' && $data['result'] == 'success') {
                    $tp++;
                } else if ($data['real_result'] == 'fail' && $data['result'] == 'fail') {
                    $tn++;
                } elseif ($data['real_result'] == 'success' && $data['result'] == 'fail') {
                    $fn++;
                } elseif ($data['real_result'] == 'fail' && $data['result'] == 'success') {
                    $fp++;
                }
            }

            if (!isset($performances[$keys])) {
                $performances[$keys] = [];
            }

            // echo "true positive = " . $tp . br();
            // echo "true negative = " . $tn . br();
            // echo "false positive = " . $fp . br();
            // echo "false negative = " . $fn . br();
            $accuracy = ($tp + $tn) / ($tp + $tn + $fp + $fn);
            $precision = $tp / ($tp + $fp);
            $recall = $tp / ($tp + $fn);
            $performances[$keys]['tp'] = $tp;
            $performances[$keys]['fn'] = $fn;
            $performances[$keys]['tn'] = $tn;
            $performances[$keys]['fp'] = $fp;
            $performances[$keys]['accuracy'] = $accuracy;
            $performances[$keys]['precison'] = $precision;
            $performances[$keys]['recall'] = $recall;
            echo "akurasi = " . $accuracy * 100 . br();
            echo "precision = " . $precision * 100 . br();
            echo "recall = " . $recall * 100 . br();
            $tp = $tn = $fp = $fn = 0;



            $count++;
        }
        // echo "<pre>";
        // print_r($performances);
        // echo "</pre>";

        return $performances;
    }
}
