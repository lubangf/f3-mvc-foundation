<?php
require_once 'vendor/autoload.php';
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Monolog\Handler\RotatingFileHandler;

class BaseController {
	/** @var \Base $app */
	protected $app;
	/** @var bool $render Flag to auto render view */
	protected $render = true;

	function __construct(){
		$this->app = Base::instance();
        $module = $this->app->get("PARAMS.module");
        $module = $module ? $module : $this->app->get("DefaultModule");
        $session = $this->app->get("SESSION");
        if(isset($session['message'])){
            $this->app->set('message', $session['message']);
            $this->app->set('message_severity', $session['message_severity']);
            $this->app->set('message_text', $session['message_text']);
        }
        $this->logger = new Logger('Georeport');
        $this->logger->pushHandler(new RotatingFileHandler($this->app->get('log_file'), $this->app->get('log_level')));
        $this->app->concat('UI',';app/'.$module.'/views/');
        $this->app->set('LOCALES', 'app/' . $module . '/dict/'); // load module dictionary
	}

	function afterroute(){
		if($this->render){
            $param = $this->app->get('PARAMS');
            $action = empty($param['action'])?'index':$param['action'];
            echo Template::instance()->render("layout.html");
        }
        $session = $this->app->get("SESSION");
        $session['message'] = False;
        $session['message_severity'] = '';
        $session['message_text'] = '';
        $this->app->set('SESSION', $session);
	}
}
