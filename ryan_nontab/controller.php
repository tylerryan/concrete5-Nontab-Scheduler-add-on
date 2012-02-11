<?php defined('C5_EXECUTE') or die(_("Access Denied."));
/**
 * @author rtyler concrete5.org/profile/-/9
 *
 */
class RyanNontabPackage extends Package {

	protected $pkgHandle = 'ryan_nontab';
	protected $appVersionRequired = '5.5';
	protected $pkgVersion = '1.1';
	
	public function getPackageDescription() {
		return t("Runs scheduled jobs without using crontab.");
	}
	
	public function getPackageName() {
		return t("Nontab Scheduler");
	}
	
	public function install() {
		if(!function_exists('curl_init')) {	
			throw new Exception(t("Nontab requires PHP's CURL extensions"));
		}
		$pkg = parent::install();
		
		$pkg->saveConfig('NONTAB_ENABLED', true);
		$pkg->saveConfig('NONTAB_TIME_LAST_RUN', time());
		$pkg->saveConfig('NONTAB_UNIT', 'days');
		$pkg->saveConfig('NONTAB_VALUE', '7');
		
		Loader::model('single_page');
		// add page for configuration
		$dp = SinglePage::add('dashboard/system/optimization/nontab', $pkg);
		$dp->update(array('cName'=>t("Nontab Scheduler"), 'cDescription'=>t("Nontab Schedule Settings")));
	}
	
	public function upgrade() {
		$pkg = Package::getByHandle($this->pkgHandle);
		parent::upgrade();
		$oldDash = Page::getByPath('/dashboard/nontab');
		if($oldDash instanceof Page && $oldDash->getCollectionID()) {
			$oldDash->delete();
		}
	
		Loader::model('single_page');
		// add page for configuration
		$dp = SinglePage::add('dashboard/system/optimization/nontab', $pkg);
		$dp->update(array('cName'=>t("Nontab Scheduler"), 'cDescription'=>t("Nontab Schedule Settings")));
	}
	
	
	public function on_start() {  
		$pkg = Package::getByHandle($this->pkgHandle);
		if($pkg->config('NONTAB_ENABLED')) {
			Events::extend('on_render_complete',
				'NonTab',
				'checkRunJobs',
				'packages/'.$this->pkgHandle.'/models/nontab.php'
				);
		}
	}
}