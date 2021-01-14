<?php 
if (!class_exists("AvObjects")) {
	class AvObjects {
		protected $_prop=array();
		protected $_db;
		public $debug;

		function __construct() {
			$this->debug=false;
		}

		public function debugValue() {
		}
		
		public function get($theProp) {
			return $this->_prop[$theProp];
		}

		public function getAllProp() {
			return $this->_prop;
		}

		public function clear($theProp="") {
			if ($theProp=="") {
				foreach ($this->_prop as $k=>$v) {
					unset($this->_prop[$k]);
				}
			} else {
					unset($this->_prop[$theProp]);
			}
		}

		public function set($theProp,$newValue) {
			$oldValue=$this->get($theProp);
			$this->_prop[$theProp] = $newValue;
			return $oldValue;
		}

		protected function InternalFetch($resultID) {
			$res=array();

			for ($i=0; $i<$resultID->FieldCount(); $i++) {
				$fld = $resultID->FetchField($i);
				$fldName = $fld->name;
				$isi = $resultID->Fields($fldName);
				$res[$fldName] = $isi;
			}

			return $res;
		}

		public function setDB($db) {
			$this->_db = $db;
		}
	}
}