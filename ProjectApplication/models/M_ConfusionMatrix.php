<?php
class M_ConfusionMatrix extends CI_Model
{
    private $kfold = 5;
    public function splitData()
    {
        $dataSet = $this->db->get('posterior')->result_array();
        $dataSplitted = [];
        // echo "<pre>";
        // print_r($dataSet);
        // echo "</pre>";
        for ($i = 0; $i < $this->kfold; $i++) {
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
        $tp = $tn = $fp = $fn = $totalTP = $totalTN = $totalFP = $totalFN = 0;
        $count = 0;
        $performances = [];
        $avgaccuracy = $avgPrecision = $avgrecall = 0.0;

        foreach ($dataset as $keys => $tuples) {
            // echo "performance dari k-" . $key . br();
            foreach ($tuples as $key => $data) {

                // if ($data['real_result'] == 'success') {
                //     if ($data['result'] == 'success') {
                //         echo "real result = " . $data['real_result'] . br();
                //         echo "predicted result = " . $data['result'] . br();
                //         echo "=============================================" . br();
                //         $tn++;
                //     } elseif ($data['result'] == 'fail') {
                //         echo "real result = " . $data['real_result'] . br();
                //         echo "predicted result = " . $data['result'] . br();
                //         echo "=============================================" . br();

                //         $fp++;
                //     }
                // } else if ($data['real_result'] == 'fail') {
                //     if ($data['result'] == 'fail') {
                //         echo "real result = " . $data['real_result'] . br();
                //         echo "predicted result = " . $data['result'] . br();
                //         echo "=============================================" . br();

                //         $tp++;
                //     } else  if ($data['real_result'] == 'success') {
                //         echo "real result = " . $data['real_result'] . br();
                //         echo "predicted result = " . $data['result'] . br();
                //         echo "=============================================" . br();

                //         $fn++;
                //     }
                // }
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

            // echo "performance for this iteration : " . br();
            // echo "true fail = " . $tp . br();
            // echo "false success = " . $fn . br();
            // echo "true success = " . $tn . br();
            // echo "false fail = " . $fp . br();
            if (!isset($performances[$keys])) {
                $performances[$keys] = [];
            }


            $bottomDivAccr = (($tp + $tn + $fp + $fn) == 0) ? 1 : ($tp + $tn + $fp + $fn);
            $bottomDivPrecisionSuccess = (($tn + $fn) == 0) ? 1 : ($tn + $fn);
            $bottomDivRecallSuccess = (($tn + $fp) == 0) ? 1 : ($tn + $fp);
            $bottomDivPrecisionFail = (($tp + $fp) == 0) ? 1 : ($tp + $fp);
            $bottomDivRecallFail = (($tp + $fn) == 0) ? 1 : ($tp + $fn);
            $accuracy = ($tp + $tn) / $bottomDivAccr;
            $precision = $tp / $bottomDivPrecisionFail;
            $recall = $tp / $bottomDivRecallFail;
            $precisionSuccess = $tn / $bottomDivPrecisionSuccess;
            $recallSuccess = $tn / $bottomDivRecallSuccess;
            $totalTP += $tp;
            $totalTN += $tn;
            $totalFP += $fp;
            $totalFN += $fn;
            $performances[$keys]['tp'] = $tp;
            $performances[$keys]['fn'] = $fn;
            $performances[$keys]['tn'] = $tn;
            $performances[$keys]['fp'] = $fp;
            $performances[$keys]['accuracy'] = $accuracy;
            $performances[$keys]['precision'] = $precision;
            $performances[$keys]['recall'] = $recall;
            $performances[$keys]['precisionsuccess'] = $precisionSuccess;
            $performances[$keys]['recallsuccess'] = $recallSuccess;
            $avgaccuracy += $accuracy;
            $avgPrecision += $precision;
            $avgrecall += $recall;
            $tp = $tn = $fp = $fn = 0;
            $count++;
        }


        // echo "total TP = " . $totalTP . br();
        // echo "total TN = " . $totalTN . br();
        // echo "total FP = " . $totalFP . br();
        // echo "total FN = " . $totalFN . br();
        // die;

        $avgaccuracy /= $this->kfold;
        $performances['totalTP'] = $totalTP;
        $performances['totalTN'] = $totalTN;
        $performances['totalFP'] = $totalFP;
        $performances['totalFN'] = $totalFN;
        $performances['avgAccuracy'] = ($totalTN + $totalTP) / ($totalTP + $totalTN + $totalFP + $totalFN);
        $performances['avegRecalPositive'] = $totalTP / ($totalTP + $totalFN);
        $performances['avegRecalNegative'] = $totalTN / ($totalTN + $totalFP);
        $performances['avgprecisionPositive'] = $totalTP / ($totalTP + $totalFP);
        $performances['avgprecisionNegative'] = $totalTN / ($totalTN + $totalFN);
        $performances['sensitivity'] = $totalTP / ($totalTP + $totalFN);
        $performances['specificity'] = $totalTN / ($totalTN + $totalFP);
        $performances['avgprecisionNegative'] = $totalTP / ($totalTN + $totalFN);
        $performances['avgrecall'] = $avgrecall / $this->kfold;
        // echo "<pre>";
        // print_r($avgaccuracy);
        // print_r($performances);
        // echo "</pre>";
        // die;
        $data = [
            "sampling_percentage" => $this->session->userdata("sampling_percentage"),
            "amount_of_knn" => $this->session->userdata("amount_of_knn"),
            "true_positive" => $totalTP,
            "false_negative" => $totalFN,
            "true_negative" => $totalTN,
            "false_positive" => $totalFP,
            "accuracy" => $performances['avgAccuracy'],
            "presisi" => $performances['avgprecisionPositive'],
            "recall" => $performances['avegRecalPositive'],
            "sensitivity" => $performances['avegRecalPositive'],
            "specificity" => $performances['avegRecalNegative'],
            "f1Score" => ((2 * $performances['avgprecisionPositive'] * $performances['avegRecalPositive']) / ($performances['avgprecisionPositive'] + $performances['avegRecalPositive'])),
            "status" => $this->session->userdata("status")
        ];
        $this->db->insert("performances", $data);


        // die;

        return $performances;
    }
}
