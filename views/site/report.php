<?php
use yii\helpers\Html;
use app\assets\ChartAsset;
ChartAsset::register($this);

if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}

$this->title = 'Report for Project ' . $id;

$charts = ['line', 'campbell'];

$system = $project->projectsetting->systemoptions;
$results = $project->projectsetting->resultoptions;

if($results['staticLine']) {
    if(file_exists($path."line.json")) {
        $string = file_get_contents($path."line.json");
        $json = json_decode($string, true);
        // var_dump($json);
        echo $this->render('_line', [ 'model' => $json ] );
    }
}

if($results['campbell']) {
    $file1 = 'campbell';
    $file2 = 'instabilities';
    if($system['ves']) {
        $file1 = 'campbell3d';
        $file2 = 'estabilities';
    }

    $json1 = [];
    $json2 = [];
    if(file_exists($path.$file1.".json")) {
        $string = file_get_contents($path.$file1.".json");
        $json1 = json_decode($string, true);
    }
    if(file_exists($path.$file2.".json")) {
        $string = file_get_contents($path.$file2.".json");
        $json2 = json_decode($string, true);
    }
    echo $this->render('_campbell', [ 'model' => $json1, 'model2' => $json2, 'hasVes' => $system['ves'] ] );
}

if($results['criticalMap']) {
    $json1 = [];
    $json2 = [];
    if(file_exists($path."critical3d.json")) {
        $string = file_get_contents($path."critical3d.json");
        $json1 = json_decode($string, true);
    }
    if(file_exists($path."critical2d.json")) {
        $string = file_get_contents($path."critical2d.json");
        $json2 = json_decode($string, true);
    }
    echo $this->render('_stiff', [ 'model' => $json1, 'model2' => $json2 ] );
}

if($results['modes']) {
    if(file_exists($path."modes.json")) {
        $string = file_get_contents($path."modes.json");
        $json = json_decode($string, true);
        echo $this->render('_modes', [ 'model' => $json ] );
    }
}

if($results['constantResponse']) {
    $json1 = [];
    $json2 = [];
    if(file_exists($path."cte_amplitude.json")) {
        $string = file_get_contents($path."cte_amplitude.json");
        $json1 = json_decode($string, true);
    }
    if(file_exists($path."cte_unbalance.json")) {
        $string = file_get_contents($path."cte_unbalance.json");
        $json2 = json_decode($string, true);
    }
    echo $this->render('_cte', [ 'model' => $json1, 'model2' => $json2 ] );
}

if($results['unbalanceResponse']) {
    $json1 = [];
    $json2 = [];
    if(file_exists($path."unb_amplitude.json")) {
        $string = file_get_contents($path."unb_amplitude.json");
        $json1 = json_decode($string, true);
    }
    if(file_exists($path."unb_unbalance.json")) {
        $string = file_get_contents($path."unb_unbalance.json");
        $json2 = json_decode($string, true);
    }
    echo $this->render('_unb', [ 'model' => $json1, 'model2' => $json2 ] );
}

if($results['timeResponse']) {
    if(file_exists($path."time.json")) {
        $string = file_get_contents($path."time.json");
        $json = json_decode($string, true);
        echo $this->render('_time', [ 'model' => $json ] );
    }
}

if($results['torsional']) {
    $json1 = [];
    $json2 = [];
    $json3 = [];
    if(file_exists($path."torsion.json")) {
        $string = file_get_contents($path."torsion.json");
        $json1 = json_decode($string, true);
    }
    if(file_exists($path."tor_amplitude.json")) {
        $string = file_get_contents($path."tor_amplitude.json");
        $json2 = json_decode($string, true);
    }
    if(file_exists($path."tor_unbalance.json")) {
        $string = file_get_contents($path."tor_unbalance.json");
        $json3 = json_decode($string, true);
    }
    echo $this->render('_torsional', [ 'model' => $json1, 'model2' => $json2, 'model3' => $json3 ] );
}

?>
