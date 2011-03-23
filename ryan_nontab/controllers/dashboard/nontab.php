<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardNontabController extends Controller {
	public $helpers = array("form");
	
	public function __construct() {
		$unit_values = array('hours'=>t('Hours'),
				'days'=>t('days'),
				'weeks'=>t('Weeks'),
				'months'=>t('Months')		
			);
		$this->set('unit_values',$unit_values);
		parent::__construct();
	}

	public function save_settings() {
		$pkg = Package::getByHandle('ryan_nontab');
        $pkg->saveConfig('NONTAB_ENABLED', $this->post('NONTAB_ENABLED'));
		$pkg->saveConfig('NONTAB_UNIT', $this->post('NONTAB_UNIT'));
		$pkg->saveConfig('NONTAB_VALUE', $this->post('NONTAB_VALUE'));
        $this->set('message',t('Settings have been saved.'));
	}

	public function view() {
		$pkg = Package::getByHandle('ryan_nontab');
		$this->set('nontab_enabled',$pkg->config('NONTAB_ENABLED'));
		$this->set('nontab_unit',$pkg->config('NONTAB_UNIT'));
		$this->set('nontab_value',$pkg->config('NONTAB_VALUE'));
	}
}
?>