<?php 
	namespace UserView\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\ViewModel;

	class UserViewController extends AbstractActionController {
		protected $_userViewTable;

	    public function indexAction() {
	    	 return new ViewModel(array(
                    'userviews' => $this->getUserViewTable()->fetchAll(),
                ));
	    }

	    public function addAction(){
	    	$request = $this->getRequest();
	    	$response = $this->getResponse();
	    	if($request->isPost()){
	    		$new_user = new \UserView\Model\Entity\User();
	    	
	    		if(!$user_id = $this->getUserViewTable()->saveUserView($new_user)){
	    			$response->setContent(\Zend\Json\Json::encode(array('response' => false)));
	    		}
	    		else{
	    			$response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_user_id' => $user_id)));
	    		}
	    	}
	    		
	    	return $response;
	    }

	    public function removeAction() {
	    	$response = $this->getResponse();
	    	$request = $this->getRequest();
	    	if($request->isPost()){
	    		$data = $request->getPost();
	    		$id = $data['id'];
	    		$row = $this->getUserViewTable()->removeUserView($id);
	    		if(!$row){
	    			$response->setContent(\Zend\Json\Json::encode(array('response'=> false)));
	    		}else{
	    			$response->setContent(\Zend\Json\Json::encode(array('response'=> true)));
	    		}
	    	}
	    	return $response;
	    }

	    public function updateAction(){
	    	$request = $this->getRequest();
	    	$response = $this->getResponse();
	    	if($request->isPost()){
	    		$post = $request->getPost();
	    		$id = $post['id'];
		    	$name = $post['name'];
		    	$password = $post['password'];
		    	$user = $this->getUserViewTable()->getUserView($id);
		    	$user->setName($name);
		    	$user->setPassword($password);

		    	if(!$this->getUserViewTable()->saveUserView($user))
		    		$response->setContent(\Zend\Json\Json::encode(array('response' => false)));
		    	else{
		    		$response->setContent(\Zend\Json\Json::encode(array('response' => true,'name'=>$user)));
		    	}
		    }
	    	return $response;
	    }

	    public function checknameAction(){
	    	$request = $this->getRequest();
	    	$response = $this->getResponse();
	    	if($request->isPost()){
	    		 $post_data = $request->getPost();
	    		 $user_name = $post_data['user'];
	    		 $user_view = $this->getUserViewTable()->getUserByName($user_name);
	 			if(!$user_view){
	 				$response->setContent(\Zend\Json\Json::encode(array('response' => true)));
	 			}
	 			else{
	 				$response->setContent(\Zend\Json\Json::encode(array('response' => false)));
	 			}
	    	}
	    	return $response;
	    }
	    public function getUserViewTable() {
	        if (!$this->_userViewTable) {
	            $sm = $this->getServiceLocator();
	            $this->_userViewTable = $sm->get('UserView\Model\UserViewTable');
	        }
	        return $this->_userViewTable;
	    }

	}

 ?>