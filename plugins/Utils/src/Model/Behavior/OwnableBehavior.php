<?php
namespace Utils\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Controller\Component\AuthComponent;
use Cake\Http\Exception\UnauthorizedException;

/**
 * Ownable behavior
 */
class OwnableBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    /**
     *  User object
     */
    public function initialize(array $config){
        parent::initialize($config);
        
        $this->User = (object) @$_SESSION['Auth']['User'];
    }
    public function ensureAuthorization($entity){
        if($this->User->role != 'admin'){
            //if update
            if(@$entity->id){
                $existing = $this->_table->findById($entity->id)->select(['user_id'])->first();

                if(@$existing->user_id != @$this->User->id){
                    //NO
                    throw new UnauthorizedException("Access to this data was unauthorized.");
                }
            }
        }        
    }
    public function beforeSave($event, $entity, $options)
    {
        // header("Content-Type: application/json");
        $this->ensureAuthorization($entity);
        // exit;
    }
    public function beforeDelete($event, $entity, $options)
    {
        // header("Content-Type: application/json");
        $this->ensureAuthorization($entity);
        // exit;
    }
}
