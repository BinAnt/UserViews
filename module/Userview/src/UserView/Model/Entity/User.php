<?php 
	namespace UserView\Model\Entity;

	class User{
		protected $_id;
		protected $_name;
		protected $_password;
		protected $_createtime;
		protected $_updatetime;

		public function __construct(array $options = null){
			if(is_array($options)){
				$this->setOptions($options);
			}
		}

		public function __set($name,$value){
			$method = 'set'.$name;
			if(!method_exists($this,$method)){
				throw new Exception('Invalid Method');
			}
			$this->$method($value);
		}

		public function __get($name){
			$method = 'get'.$name;
			if(!method_exists($this, $method)){
				throw new Exception('Invalid Method');
			}
			return $this->$method();
		}

		public function setOptions(array $options){
			$methods = get_class_methods($this);
			foreach ($options as $key => $value) {
				$method = 'set'.ucfirst($key);
				if(in_array($method,$methods)){
				 	$this->$method($value);
				 }
			}
			return $this;
		}

		public function getId(){
			return $this->_id;
		}

		public function setId($id){
			$this->_id = $id;
			return $this;
		}

		public function getName(){
			return $this->_name;
		}

		public function setName($name){
			$this->_name = $name;
			return $this;
		}

		public function getPassword(){
			return $this->_password;
		}

		public function setPassword($password){
			$this->_password = $password;
			return $this;
		}

		public function getCreatetime(){
			return $this->_createtime;
		}

		public function setCreatetime($createtime){
			$this->_createtime = $createtime;
			return $this;
		}

		public function getUpdatetime(){
			return $this->_updatetime;
		}

		public function setUpdatetime($updatetime){
			$this->_updatetime = $updatetime;
			return $this;
		}
	}
 ?>