<?php 
	namespace UserView\Model;

	use Zend\Db\Adapter\Adapter;
	use Zend\Db\TableGateway\AbstractTableGateway;
	use Zend\Db\Sql\Select;
	use Zend\Db\Sql\Sql;

	class UserViewTable extends AbstractTableGateway {

	    protected $table = 'userview';

	    public function __construct(Adapter $adapter) {
	        $this->adapter = $adapter;
	    }

	    public function fetchAll(){
	    	$resultSet = $this->select(function(Select $select){
	    		$select->order('createtime ASC');
	    	});
	    	$entities = array();
	    	foreach ($resultSet as $row) {
	    		$entity = new Entity\User();
	    		$entity->setId($row->id)
	    			   ->setName($row->name)
	    			   ->setPassword($row->password)
	    			   ->setCreatetime($row->createtime)
	    			   ->setUpdatetime($row->updatetime);
	    		$entities[] = $entity;
	    	}
	    	return $entities;
	    }

	    public function getUserView($id){
	    	$row = $this->select(array('id' => (int)$id))->current();

	    	if(!$row)
	    		return false;

	    	$userView = new Entity\User(array(
	    		'id' => $row->id,
	    		'name' => $row->name,
	    		'password' => $row->password,
	    		));
	    	return $userView;
	    }

	    public function getUserByName($name){
	  		$resultSet = $this->select(function(Select $select) use ($name){
	  			$select->where(array('name'=>$name));
	    		$select->order('createtime ASC');
	    	});
	    	$entities = array();
	    	foreach ($resultSet as $row) {
	    		$entity = new Entity\User();
	    		$entity->setId($row->id)
	    			   ->setName($row->name)
	    			   ->setPassword($row->password)
	    			   ->setCreatetime($row->createtime)
	    			   ->setUpdatetime($row->updatetime);
	    		$entities[] = $entity;
	    	}
	    	return $entities;
	    	
	    }
	    public function saveUserView(Entity\User $user){
	    	$data = array(
	    		'name' => $user->getName(),
	    		'password' => $user->getPassword(),
	    		);

	    	$id = (int)$user->getId();
	    	if($id == 0){
	    		$data['createtime'] = date("Y-m-d H:i:s");
	    		if(!$this->insert($data))
	    			return false;
	    		return $this->getLastInsertValue();
	    	}
	    	elseif($this->getUserView($id)){
	    		$data['updatetime'] = date("Y-m-d H:i:s",time());
	    		if(!$this->update($data,array('id' => $id)))
	    			return false;
	    		return $id;
	    	}
	    	else
	    		return false;
	    }

	    public function removeUserView($id) {
	        return $this->delete(array('id' => (int) $id));
	    }
	}
 ?>