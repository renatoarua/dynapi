<?php
namespace app\commands;
set_time_limit(0);

use Yii;
use yii\console\Controller;

class RotordynController extends Controller
{
	public $message;

	public function options($actionID)
	{
		return ['message'];
	}

	public function optionAliases()
	{
		return ['m' => 'message'];
	}

	public function actionIndex()
	{
		echo $this->message . "\n";
	}

	public function actionRunMachine($id) {
		return $this->executeAsyncShellCommand($id);
	}

	private function executeAsyncShellCommand($id = null) {
		if(!$id) {
			throw new Exception("No ID given");
		}

		$baseDir = "C:/wamp64/www/dyntech/yiiangular/app";
		$logDir = $baseDir."/saved/projects/$id";
		$python = "C:/Program Files/Python35/python.exe";
		$command = "$python $baseDir/app.py $id";

		if (!file_exists($logDir)) {
			mkdir($logDir, 0777, true);
		}

		$log = "$logDir/log_".date('Y_m_d\Th_i_s').".txt";

		$pid = $this->run_process($command, $log);
		return $pid;
	}

	protected function run_process($cmd, $outputFile = '/dev/null', $append = false){
		$pid=0;
		//'This is a server using Windows!';
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$cmd = 'wmic process call create "'.$cmd.'" | find "ProcessId"';
			$baseDir = "C:/wamp/www/dyntech/yiiangular/app";
			$handle = popen('start /B '. $cmd, "r");
			$read = fread($handle, 200); //Read the output 
			$pid=substr($read,strpos($read,'=')+1);
			$pid=substr($pid,0,strpos($pid,';') );
			$pid = (int)$pid;
			pclose($handle); //Close
		} else {
			$cmd = sprintf('%s %s %s 2>&1 & echo $!', $cmd, ($append) ? '>>' : '>', $outputFile);
			$pid = (int)shell_exec($cmd);
		}
		return $pid;
	}
}

// wmic process call create 'python C:/wamp/www/dyntech/yiiangular/app/app.py 9zVKNtAevxFcr3ZxuNr3e' | find "ProcessId"