<?php
class M_ConfusionMatrix extends CI_Model
{
    public function splitData()
    {
        $dataSet = $this->db->get('posterior')->result_array();
        $dataSplitted = [];
        // echo "<pre>";
        // print_r($dataSet);
        // echo "</pre>";
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

        // echo "<pre>";
        // print_r($dataSplitted);
        // echo "</pre>";
        return $dataSplitted;
    }


    public function performance()
    {
        $dataset = $this->splitData();
        $tp = $tn = $fp = $fn = 0;
        $count = 0;
        $performances = [];
        $avgaccuracy = 0.0;

        foreach ($dataset as $keys => $tuples) {
            // echo "performance dari k-" . $key . br();
            foreach ($tuples as $key => $data) {

                if ($data['real_result'] == 'success' && $data['result'] == 'success') {
                    $tn++;
                } else if ($data['real_result'] == 'fail' && $data['result'] == 'fail') {
                    $tp++;
                } elseif ($data['real_result'] == 'success' && $data['result'] == 'fail') {
                    $fp++;
                } elseif ($data['real_result'] == 'fail' && $data['result'] == 'success') {
                    $fn++;
                }
            }

            if (!isset($performances[$keys])) {
                $performances[$keys] = [];
            }

            // echo "true positive = " . $tp . br();
            // echo "true negative = " . $tn . br();
            // echo "false positive = " . $fp . br();
            // echo "false negative = " . $fn . br();
            $bottomDivAccr = (($tp + $tn + $fp + $fn) == 0) ? 1 : ($tp + $tn + $fp + $fn);
            $bottomDivPre = (($tp + $fp) == 0) ? 1 : ($tp + $fp);
            $bottomDivRec = (($tp + $fn) == 0) ? 1 : ($tp + $fn);
            $accuracy = ($tp + $tn) / $bottomDivAccr;
            $precision = $tp / $bottomDivPre;
            $recall = $tp / $bottomDivRec;
            $performances[$keys]['tp'] = $tp;
            $performances[$keys]['fn'] = $fn;
            $performances[$keys]['tn'] = $tn;
            $performances[$keys]['fp'] = $fp;
            $performances[$keys]['accuracy'] = $accuracy;
            $performances[$keys]['precision'] = $precision;
            $performances[$keys]['recall'] = $recall;
            $avgaccuracy += $accuracy;
            $tp = $tn = $fp = $fn = 0;



            $count++;
        }
        // echo "<pre>";
        // print_r($performances);
        // echo "</pre>";


        $avgaccuracy /= $this->session->userdata('kfold');
        $performances['avgAccuracy'] = $avgaccuracy;
        return $performances;
    }
}
