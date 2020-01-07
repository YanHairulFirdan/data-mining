<?php if (!defined('BASEPATH')) exit('No Direct Script Access Allowed');

require_once APPPATH . 'jpgraph/src/jpgraph.php';
require_once APPPATH . 'jpgraph/src/jpgraph_line.php';
require_once APPPATH . 'jpgraph/src/jpgraph_bar.php';

class graph extends Graph
{
    public function __construct($panjang, $lebar)
    {
        parent::__construct($panjang, $lebar);
    }
}

class lineP extends LinePlot
{
    public function __construct($data)
    {
        parent::__construct($data);
    }
}

class BarP extends BarPlot
{
    public function __construct($data)
    {
        parent::__construct($data);
    }
}
