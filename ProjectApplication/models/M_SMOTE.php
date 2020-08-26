<?php
class M_Smote extends CI_Model
{
	const kVal = 5;
	private $nnArray = [];
	const numberOfAttributes = 8;
	public static $allData = [];
	public static $syntheticData = [];
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
	public static $diskretData = [];
	// public function getMinoritydata()
	// {
	// 	$this->roundingVal();
	// 	$this->diskritVal();
	// 	return self::$syntheticData;
	// }

	public function smote($numberDataSample, $percentage, $kVal)
	{

		if ($percentage < 100) {
			$numberDataSample = ($percentage / 100) * $numberDataSample;
		}
		$percentage /= 100;

		for ($i = 0; $i < $numberDataSample; $i++) {
			$this->nnArray = $this->euclideanDistance($this->dataset[$i]);
			$this->populateData($percentage, $i, $this->nnArray);
		}
	}
	private function euclideanDistance($currentData)
	{
		$distance = [];
		$sortDistance = [];
		$currentDataDistance = [];
		//looping dataset
		foreach ($this->dataset as $key => $data) {
			if ($currentData != $data) {
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
				// echo"jarak dengan data ke-".$key." = ". $totalDistance."<br>";
				array_push($distance, $totalDistance);
				array_push($sortDistance, $totalDistance);
			}
		}

		sort($sortDistance);


		return $this->getNeatestDistanceNeighbors($distance, $sortDistance);
	}

	// private function mappinDistance(){}

	private function getNeatestDistanceNeighbors($nearestNeighborsList, $sorterNeirestNeigborList)
	{
		$i = 0;
		$nearestIndex = [];
		while ($i < self::kVal) {
			$index = array_search($sorterNeirestNeigborList[$i], $nearestNeighborsList, true);
			array_push($nearestIndex, $index);
			$i++;
		}

		return $nearestIndex;
	}


	private function roundingVal()
	{
		for ($i = 0; $i < count(self::$syntheticData); $i++) {
			for ($j = 0; $j < 8; $j++) {
				if ($j != 2) {
					self::$syntheticData[$i][$j] = round(self::$syntheticData[$i][$j]);
				}
			}
		}
	}
	private function populateData($percentage, $indexData, $nnArray)
	{
		$syntheticTemp = [];
		while ($percentage != 0) {

			$nn = rand(0, 4);

			for ($i = 0; $i < self::numberOfAttributes; $i++) {
				$diff = $this->dataset[$nnArray[$nn]][$i] - $this->dataset[$indexData][$i];
				$gap = mt_rand() / mt_getrandmax();
				$result = $this->dataset[$indexData][$i] + $gap * $diff;
				$result = number_format($result, 2);
				array_push($syntheticTemp, $result);
			}

			// echo "<pre>";
			// 	print_r($syntheticTemp);
			// echo "</pre>";
			array_push(self::$syntheticData, $syntheticTemp);
			$syntheticTemp = [];
			$percentage--;
		}
	}

	private function diskritVal()
	{
		$arrayOfLabel = ['sex', 'age', 'time', 'number_of_warts', 'type', 'area', 'induration_diameter', 'result_of_treatement'];
		$diskretVal = [];
		foreach (self::$syntheticData as $key => $singleTuple) {
			foreach ($singleTuple as $index => $tuple) {
				switch ($index) {
					case 0:
						if ($tuple == 1) {
							$diskretVal[$arrayOfLabel[$index]] = 'male';
						} else {
							$diskretVal[$arrayOfLabel[$index]] = 'female';
						}
						break;
					case 1:
					case 2:
					case 3:
					case 5:
					case 6:
						$diskretVal[$arrayOfLabel[$index]] = $tuple;
						break;
					case 4:
						if ($tuple == 1) {
							$diskretVal[$arrayOfLabel[$index]] = 'common';
						} elseif ($tuple == 2) {
							$diskretVal[$arrayOfLabel[$index]] = 'plantar';
						} else {
							$diskretVal[$arrayOfLabel[$index]] = 'both';
						}

						break;
					case 7:
						if ($tuple == 0) {
							$diskretVal[$arrayOfLabel[$index]] = 'fail';
						} else {
							$diskretVal[$arrayOfLabel[$index]] = 'success/5';
						}

					default:
						# code...
						break;
				}
			}
			array_push(self::$diskretData, $diskretVal);
		}
		$diskretVal = [];
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

	function getsampleddata()
	{
		// $totalDataSet = [];
		$this->roundingVal();
		$this->diskritVal();
		self::$allData = array_merge($this->dataset, $this->majoritydata, self::$syntheticData);
		shuffle(self::$allData);
		$dataset['dataset'] = self::$allData;
		$data[0] = count(array_merge($this->dataset, self::$syntheticData));
		$data[1] = count($this->majoritydata);
		$dataset['count'] = $data;
		return $dataset;
	}

	function savedata()
	{

		// $totalDataSet = shuffle($totalDataSet);


		echo "<pre>";
		print_r(self::$allData);
		echo "</pre>";
		// self::$allData = array_merge($this->dataset, $this->majoritydata, self::$syntheticData);
	}
}
