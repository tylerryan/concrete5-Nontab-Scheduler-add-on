<?php    
defined('C5_EXECUTE') or die(_("Access Denied."));
class NonTab {
	
	/**
	 * @return void
	 */
	public static function checkRunJobs() {
		$nt = new NonTab();
		if($nt->shouldRunNow()) {
			$pkg = Package::getByHandle('ryan_nontab');
			$pkg->saveConfig('NONTAB_TIME_LAST_RUN', time());
			$ch = curl_init($nt->getJobsUrl());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,1);
			curl_setopt($ch,CURLOPT_TIMEOUT,1);
			$res = curl_exec($ch);
			/*
			if($res !== true) {
				Log::addEntry("Nontab Job Run Error: ".var_export($res,true));
			}
			*/
			curl_close($ch);
		}
	}
	
	/**
	 * @return boolean
	 */
	protected function shouldRunNow() {	
		$pkg = Package::getByHandle('ryan_nontab');
		$last_run = (int) $pkg->config('NONTAB_TIME_LAST_RUN');
		$unit = $pkg->config('NONTAB_UNIT');
		$value = $pkg->config('NONTAB_VALUE');
		$seconds = 1;
		switch($unit){
			case "hours":
				$seconds = 60*60;
				break;
			case "days":
				$seconds = 60*60*24;
				break;
			case "weeks":
				$seconds = 60*60*24*7;
				break;
			case "months":
				$seconds = 60*60*24*7*30;
				break;
		}
		$gap = $value * $seconds;
		if($last_run < (time() - $gap) ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @return string
	 */
	protected function getJobsUrl() {
		Loader::model('job');
		$auth = Job::generateAuth();
		return BASE_URL . View::url('/tools/required/jobs?auth=' . $auth);
	}
}
?>