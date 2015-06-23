<?php
class View {
	private $_template;
	private $_params;
	public static $tplDir = "tmpl";

	public function  __construct($template, $params = array()) {
		$this->_template = $template;
		$this->setParams($params);
	}
	public function display() {
		extract($this->_params);
		$tplpath = self::$tplDir . '/';
		if (!empty($this->_params['platform']) && file_exists($tplpath . $this->_params['platform'] . '/' . $this->_template . ".php")) {
			$tplpath = $tplpath . $this->_params['platform'] . '/';
		}
		include $tplpath . $this->_template . ".php";
	}
	public function fetch() {
		ob_start();
		$this->display();
		$out = ob_get_clean();
		return $out;
	}
	public function setParams($params) {
		$this->_params = $params;
	}
	public function setParam($name, $value) {
		$this->_params[$name] = $value;
	}
	public function getParam($name, $default = null) {
		if (isset ($this->_params[$name])) {
			return $this->_params[$name];
		}
		return $default;
	}
}

