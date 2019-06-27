<?php
namespace Utils\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * History behavior
 */
class HistoryBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function initialize(array $config){
        $this->config = $config;
    }
    public function beforeSave($event,$entity,$options){
        
        // header("Content-Type: application/json");
        // if(@$this->config['beforeSave'])
        //     $this->config['beforeSave']($event,$entity,$options);
        
        // echo json_encode([$event,$entity,$options,$this->config]);
        // exit;
    }
}
