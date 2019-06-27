<?php
namespace Utils\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Duplicatable behavior
 */
class DuplicatableBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function copy($id){
        
        $data = $this->_table->findById($id)->first()->toArray();
        $e = $this->_table->newEntity();
        foreach(array_keys($data) as $field){
            if($field != 'id' && $field != 'created' && $field != 'modified'){
                $e->$field = $data[$field];
            }
        }
        
        return $this->_table->save($e);
        
    }

}
