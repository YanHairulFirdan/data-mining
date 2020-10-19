<?php
class M_Smote extends CI_Model
{
	public $kVal;
	private $nnArray = [];
	const numberOfAttributes = 8;
	public static $allData = [];
	public static $syntheticData = [];
	private $columnName = ['sex', 'age', 'time', 'number_of_warts', 'type', 'area', 'induration_diameter', 'result_of_treatment', 'data_type'];
	public $dataset = [
		[2,	32,	12,		6,	3,	35,	5,	0],
		[2,	15,	1.75,	1,	2,	49,	7,	0],
		[2,	26,	10.5,	6,	1,	50,	9,	0],
		[1,	15,	11,	6,	1,	30,	25,	0],
		[2,	34,	11.5,	12,	1,	25,	50,	0],
		[1,	34,	5,		7,	3,	64,	7,	0],
		[2,	41,	11,		11,	2,	21,	6,	0],
		[1,	45,	11.25,	4,	1,	72,	5,	0],
		[2,	34,	8.5,	1,	2,	163, 7,	0],
		[1,	49,	4.5,	2,	1,	33,	7,	0],
		[1,	38,	12,		14,	1,	87,	6,	0],
		[2,	56,	11.75,	7,	1,	31,	50,	0],
		[1,	27,	11.75,	8,	1,	208, 6,	0],
		[2,	47,	10.75,	8,	1,	57,	5,	0],
		[1,	33,	1.75,	7,	2,	379, 7,	0],
		[2,	28,	11,		3,	3,	91,	6,	0],
		[2,	42,	8.75,	8,	2,	73,	9,	0],
		[1,	46,	11.5,	4,	1,	91,	25,	0],
		[1,	32,	12,		9,	1,	43,	50,	0]

	];
	public $majoritydata = [
		[1,	22,	2.25,	14,	3,	51,	50,	1],
		[1,	15,	3,	2,	3,	900,	70,	1],
		[1,	16,	10.5,	2,	1,	100,	25,	1],
		[1,	27,	4.5,	9,	3,	80,	30,	1],
		[1,	20,	8,	6,	1,	45,	8,	1],
		[1,	15,	5,	3,	3,	84,	7,	1],
		[1,	35,	9.75,	2,	2,	8,	6,	1],
		[2,	28,	7.5,	4,	1,	9,	2,	1],
		[2,	19,	6,	2,	1,	225,	8,	1],
		[2,	33,	6.25,	2,	1,	30,	3,	1],
		[2,	17,	5.75,	12,	3,	25,	7,	1],
		[2,	15,	5.5,	12,	1,	48,	7,	1],
		[2,	16,	10,	7,	1,	143,	6,	1],
		[2,	33,	9.25,	2,	2,	150,	8,	1],
		[2,	26,	7.75,	6,	2,	6,	5,	1],
		[2,	23,	7.5,	10,	2,	43,	3,	1],
		[2,	15,	6.5,	19,	1,	56,	7,	1],
		[2,	26,	6.75,	2,	1,	6,	6,	1],
		[1,	22,	1.25,	3,	3,	47,	3,	1],
		[2,	19,	2.25,	2,	1,	60,	7,	1],
		[1,	25,	5.75,	2,	1,	300,	7,	1],
		[2,	17,	11.25,	4,	3,	70,	7,	1],
		[1,	27,	5,	2,	1,	20,	5,	1],
		[2,	24,	4.75,	10,	3,	30,	45,	1],
		[2,	20,	7.75,	18,	3,	45,	2,	1],
		[2,	38,	2.5,	1,	3,	43,	50,	1],
		[1,	23,	3,	2,	3,	87,	70,	1],
		[2,	48,	10.25,	7,	1,	50,	25,	1],
		[2,	24,	4.25,	1,	1,	174,	30,	1],
		[2,	33,	8,	3,	1,	502,	8,	1],
		[1,	29,	8.75,	3,	1,	504,	2,	1],
		[2,	22,	8.5,	5,	1,	99,	8,	1],
		[2,	22,	8.25,	9,	1,	352,	3,	1],
		[1,	35,	8.75,	10,	2,	69,	7,	1],
		[2,	19,	11,	5,	2,	51,	6,	1],
		[1,	21,	8,	3,	1,	17,	8,	1],
		[1,	26,	7.75,	13,	2,	13,	5,	1],
		[1,	51,	8.75,	2,	2,	57,	3,	1],
		[1,	19,	7.75,	6,	1,	32,	7,	1],
		[2,	36,	1.75,	10,	3,	45,	3,	1],
		[2,	52,	2.25,	5,	1,	63,	7,	1],
		[2,	49,	9,	4,	2,	14,	9,	1],
		[1,	23,	5.75,	2,	1,	43,	7,	1],
		[1,	45,	10,	8,	1,	58,	7,	1],
		[1,	54,	7.5,	13,	3,	43,	5,	1],
		[2,	47,	5.25,	3,	3,	23,	45,	1],
		[2,	53,	10,	1,	2,	30,	25,	1],
		[1,	27,	11.25,	3,	2,	37,	2,	1],
		[2,	47,	3.75,	14,	2,	67,	50,	1],
		[2,	19,	2.25,	8,	2,	42,	70,	1],
		[2,	33,	8,	5,	1,	63,	25,	1],
		[2,	15,	4,	12,	1,	72,	30,	1],
		[1,	17,	8.5,	2,	1,	44,	8,	1],
		[1,	29,	5,	12,	3,	75,	7,	1],
		[2,	51,	6,	6,	1,	80,	2,	1],
		[1,	35,	6.75,	4,	3,	41,	8,	1],
		[1,	43,	8,	1,	1,	59,	3,	1],
		[1,	15,	4,	4,	3,	25,	7,	1],
		[2,	51,	4,	1,	1,	65,	7,	1],
		[1,	45,	6.5,	9,	2,	49,	6,	1],
		[2,	47,	9.25,	13,	2,	367,	8,	1],
		[1,	18,	11.75,	5,	2,	13,	5,	1],
		[2,	46,	7.75,	8,	1,	40,	3,	1],
		[1,	43,	11,	7,	1,	507,	7,	1],
		[1,	30,	1,	2,	1,	88,	3,	1],
		[2,	16,	2,	11,	1,	47,	7,	1],
		[2,	15,	8,	1,	1,	55,	7,	1],
		[2,	53,	7.25,	6,	1,	81,	7,	1],
		[1,	40,	5.5,	8,	3,	69,	5,	1],
		[1,	38,	7.5,	8,	2,	56,	45,	1],
		[2,	23,	6.75,	6,	1,	19,	2,	1],

	];


	public $testDataset = [
		[2,	32,	12,		6,	3,	35,	5,	0],
		[2,	15,	1.75,	1,	2,	49,	7,	0],
		[2,	26,	10.5,	6,	1,	50,	9,	0],
		[1,	15,	11,	6,	1,	30,	25,	0],
		[2,	34,	11.5,	12,	1,	25,	50,	0]
	];
	public static $diskretData = [];
	// public function getMinoritydata()
	// {
	// 	$this->roundingVal();
	// 	$this->diskritVal();
	// 	return self::$syntheticData;
	// }

	public function smote($numberDataSample, $percentage, $kVal)
	{

		// echo "data total : ";
		// echo "<pre>";
		// print_r($this->testDataset);
		// echo "</pre>";

		$this->kVal = $kVal;

		if ($percentage < 100) {
			$numberDataSample = ($percentage / 100) * $numberDataSample;
			// echo $numberDataSample;
			// die;
			$percentage = 100;
		}
		$percentage /= 100;

		for ($i = 0; $i < $numberDataSample; $i++) {
			$this->nnArray = $this->euclideanDistance($this->dataset[$i]);
			// $this->nnArray = $this->euclideanDistance($this->testDataset[$i]);
			$this->populateData($percentage, $i, $this->nnArray);
		}

		// echo "<pre>";
		// print_r(self::$syntheticData);
		// echo "</pre>";
		// die;
		$data = ['sintetis' => self::$syntheticData];
		$this->session->set_userdata('sintetis', $data);
	}
	private function euclideanDistance($currentData)
	{
		$distance = [];
		$sortDistance = [];
		$currentDataDistance = [];
		//looping dataset
		foreach ($this->dataset as $key => $data) {
			// foreach ($this->testDataset as $key => $data) {

			if (!($currentData == $data)) {
				$totalDistance = 0;
				// looping each attributes field from currentData
				$currentDataDistance = null;
				foreach ($currentData as $indexCurrent => $value) {
					$currentDataDistance[$value] = pow(($value - $data[$indexCurrent]), 2);
				}
				// reduce to get the distance between two array
				foreach ($currentDataDistance as $currentDistance) {
					$totalDistance += $currentDistance;
				}
				$totalDistance = number_format(sqrt($totalDistance), 2);
				// array_push($distance, $totalDistance);
				$distance[$key] = $totalDistance;
				array_push($sortDistance, $totalDistance);
			}
		}
		// sort($sortDistance);
		// echo "<pre>";
		// print_r($distance);
		// echo "</pre>";
		return $this->getNeatestDistanceNeighbors($distance, $sortDistance);
	}

	// private function mappinDistance(){}

	private function getNeatestDistanceNeighbors($nearestNeighborsList, $sorterNeirestNeigborList)
	{
		$i = 0;
		$nearestIndex = [];
		while ($i < $this->kVal) {
			$index = array_search($sorterNeirestNeigborList[$i], $nearestNeighborsList, true);
			array_push($nearestIndex, $index);
			$i++;
		}
		return $nearestIndex;
	}


	private function roundingVal($data)
	{

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// die;
		for ($i = 0; $i < count($data); $i++) {
			for ($j = 0; $j < 8; $j++) {
				if ($j != 2) {
					$data[$i][$j] = round($data[$i][$j]);
				}
			}
		}

		return $data;
	}
	private function populateData($percentage, $indexData, $nnArray)
	{

		// echo 'called' . br();
		$syntheticTemp = [];
		$res = [];
		while ($percentage != 0) {

			$nn = rand(0, ($this->kVal - 1));
			// echo "index array data saat ini " . $indexData . br();
			// echo "<pre>";
			// print_r($this->testDataset[$indexData]);
			// echo "</pre>";
			// echo "index data terdekat : " . $nn;
			// echo "<pre>";
			// print_r($this->testDataset[$nnArray[$nn]]);
			// // print_r($nnArray);
			// echo "</pre>";

			for ($i = 0; $i < self::numberOfAttributes; $i++) {
				$gap = mt_rand() / mt_getrandmax();
				$diff = $this->dataset[$nnArray[$nn]][$i] - $this->dataset[$indexData][$i];

				// $diff = $this->testDataset[$nnArray[$nn]][$i] - $this->testDataset[$indexData][$i];
				// echo "hasil pengurangan : " . $diff . br();
				// echo "gap : " . $gap . br();
				$result = $this->dataset[$indexData][$i] + ($gap * $diff);
				// $result = $this->testDataset[$indexData][$i] + ($gap * $diff);
				// $result = number_format($result, 2);
				// echo "hasil perhitungan " . $result . br();
				array_push($syntheticTemp, $result);
			}

			// echo "hasil sintesis data : " . br();
			// echo "<pre>";
			// print_r($syntheticTemp);
			// echo "</pre>";
			// echo "========================== : " . br();

			array_push(self::$syntheticData, $syntheticTemp);
			$syntheticTemp = [];
			$percentage--;
		}
		// print_r($this->session->userdata('sintetis'));
		// die;


		// return $res;
	}

	private function diskritVal($datas)
	{
		$arrayOfLabel = ['sex', 'age', 'time', 'number_of_warts', 'type', 'area', 'induration_diameter', 'result_of_treatment', 'data_type'];
		$diskretVal = [];
		$temp = [];



		// echo "<pre>";
		// print_r($datas);
		// echo "</pre>";

		// die;
		foreach ($datas as $key => $singleTuple) {
			foreach ($singleTuple as $index => $tuple) {
				unset($singleTuple['id']);
				switch ($index) {
					case 'sex':
						if ($tuple == 1) {
							$diskretVal[$index] = 'male';
						} else {
							$diskretVal[$index] = 'female';
						}
						break;
					case 'age':
					case 'time':
					case 'number_of_warts':
					case 'area':
					case 'induration_diameter':
					case 'data_type':
						$diskretVal[$index] = $tuple;
						break;
					case 'type':
						if ($tuple == 1) {
							$diskretVal[$index] = 'common';
						} elseif ($tuple == 2) {
							$diskretVal[$index] = 'plantar';
						} else {
							$diskretVal[$index] = 'both';
						}

						break;
					case 'result_of_treatment':
						if ($tuple == 0) {
							$diskretVal[$index] = 'fail';
							// echo "fail\n";
						} else {
							$diskretVal[$index] = 'success';
							// echo "success\n";
						}
						break;

					default:

						break;
				}
				// echo $index . br();
			}
			// die;

			array_push($temp, $diskretVal);
		}
		$diskretVal = [];
		return $temp;
	}

	function getAllRawData()
	{
		$allData = array_merge($this->majoritydata, $this->dataset);
		shuffle($allData);
		return $allData;
	}



	function getCount()
	{
		$data[0] = strval(count($this->dataset));
		$data[1] = strval(count($this->majoritydata));

		return $data;
	}

	public function getAll()
	{
		$data = $this->db->get('kasus')->result_array();
		return $data;
	}
	function addDataType($datas, $label)
	{
		for ($i = 0; $i < count($datas); $i++) {
			$datas[$i][count($datas[$i])] = $label;
		}
		shuffle($datas);
		return $datas;
	}
	function mergeData()
	{
		self::$allData = array_merge($this->dataset, $this->majoritydata);
		self::$allData = $this->addDataType(self::$allData, 'original data');
		self::$syntheticData = $this->addDataType(self::$syntheticData, 'synthetic data');
		self::$allData = array_merge(self::$allData, self::$syntheticData);
	}
	function saverawdata($data)
	{
		$dataInsert = [];
		$dataInsert['id'] = '';
		foreach ($data as $key => $value) {
			$dataInsert[$this->columnName[$key]] = $value;
		}
		// echo "<pre>";
		// print_r($dataInsert);
		// echo "</pre>";
		$this->db->insert('rawdata', $dataInsert);
	}
	function getsampleddata()
	{
		self::$syntheticData = $this->roundingVal(self::$syntheticData);
		$this->mergeData();
		// self::$allData = $this->diskritVal(self::$allData);
		shuffle(self::$allData);
		foreach (self::$allData as $key => $data) {
			$this->saverawdata($data);
		}
		$dataset['dataset'] = self::$allData;
		$data[0] = count(array_merge($this->dataset, self::$syntheticData));
		$data[1] = count($this->majoritydata);
		$dataset['count'] = $data;
		// $this->getAll();
		return $dataset;
	}

	function savedata()
	{
		// $this->roundingVal();
		// $this->mergeData();
		$data = $this->db->get('rawdata')->result_array();

		$data = $this->diskritVal($data);
		// shuffle($data);
		// echo count(self::$diskretData);

		foreach ($data as $key => $data) {
			$insert = [
				'id' => '',
				'sex' => $data['sex'],
				'age' => $data['age'],
				'time' => $data['time'],
				'number_of_warts' => $data['number_of_warts'],
				'type' => $data['type'],
				'area' => $data['area'],
				'induration_diameter' => $data['induration_diameter'],
				'result_of_treatment' => $data['result_of_treatment'],
				'data_type' => $data['data_type'],

			];
			$this->db->insert('kasus', $insert);
		}
	}



	function testSplitData()
	{
		// $this->db->where(['data_type' => 'original data']);
		$dataset = $this->db->get('kasus')->result_array();
		$this->load->library('crossvalidation');
		$this->crossvalidation->setKfold(5);
		$dataset = $this->crossvalidation->splitData($dataset);
		// simpan data ke dalam data base dan update nilai data type
		foreach ($dataset as $key => $value) {
			// echo count($value) . "<br>";
			if ($key == 0) {
				foreach ($value as $key => $data) {
					$data_status  = ['data_status' => 'testing'];
					$this->db->where(['id' => $data['id']]);
					$this->db->update('kasus', $data_status);
				}
			} else {
				foreach ($value as $key => $data) {
					$data_status  = ['data_status' => 'training'];
					$this->db->where(['id' => $data['id']]);
					$this->db->update('kasus', $data_status);
				}
			}
		}
	}

	function changeArr($arr)
	{
		$res = [];
		$tempArr = [];
		foreach ($arr as $key => $data) {
			foreach ($data as $key => $value) {
				$tempArr[$this->columnName[$key]] = $value;
			}
			array_push($res, $tempArr);
			$tempArr = [];
		}

		return $res;
	}

	public function inputdata()
	{
		$allData = array_merge($this->majoritydata, $this->dataset);

		shuffle($allData);
		$allData = $this->changeArr($allData);
		$allData = $this->diskritVal($allData);
		foreach ($allData as $key => $data) {
			$data['id'] = '';
			$this->db->insert('kasusrealdata', $data);
		}
	}
}
