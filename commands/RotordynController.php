<?php
namespace app\commands;
set_time_limit(0);

use Yii;
use yii\console\Controller;
use app\models\User;
use app\models\Run;

use yii\web\BadRequestHttpException;

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
			throw new BadRequestHttpException(
                'Invalid parameters: No projectId given.'
            );
		}

		$user = User::findIdentity(\Yii::$app->user->getId());
        if (!$user) {
        	throw new BadRequestHttpException(
                'Invalid parameters: User not logged in!'
            );
        }

        $response = \Yii::$app->getResponse();
        $response->setStatusCode(200);

		$baseDir = "C:/wamp64/www/dyntech/yiiangular/app";
		$logDir = $baseDir."/saved/projects/$id";
		$python = "C:/Program Files/Python35/python.exe";

		$log_file = "log_".date('Y_m_d\Th_i_s').".txt";
		$run = new Run();
		$run->projectId = $id;
		$run->userId = $user->id;
		$run->date = time();
		$run->filename = $log_file;
		$run->status = 'RUN';
		$run->save();
		$runid = implode(',', array_values($run->getPrimaryKey(true)));
		$command = "$python $baseDir/app.py $id -r=$runid";

		if (!file_exists($logDir)) {
			mkdir($logDir, 0777, true);
		}

		$log = "$logDir/$log_file";

		$pid = $this->run_process($command, $log);

		$run->id = $runid;
		$run->exitcode = $pid;
		$run->save();
		return $run;
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