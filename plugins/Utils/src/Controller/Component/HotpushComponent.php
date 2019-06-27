<?php
namespace Utils\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
class Device{
    var $app;
    var $uid;
    public function __construct($app){
        $this->app = $app;   
    }
    public function connect($uid = null){
        $this->uid = $uid;
        return new RemoteObjectN($this);
    }    
}

class RemoteObject{
    var $selector = "REF_";
    var $device;
    public function __construct($device = null){
        $this->device = $device;   
    }
    public function device(){
        return $this->device;
    }
    public function __get($name){
        $this->selector .= $name .".";
        return $this;
    }
    
    public function __call($name,$args){
        return $this->selector.$name."=>".json_encode($args);
    }
}
class RemoteObjectN{
    var $selector = "REF_";
    var $device;
    public function __construct($device){
        $this->device = $device;   
    }
    public function device(){
        return $this->device;
    }
    public function __get($name){
        $this->selector .= $name .".";
        return $this;
    }
    
    public function __call($name,$args){
        $this->selector = $this->selector.$name."=>".json_encode($args);
        return $this->selector;
    }
    public function done($data = ['status' => 'success']){
        $this->app->jsonWithResponse($data,$this->ret);
    }    
}
class PopupsRef{
    var $app = null;
    var $ret = [];
    var $goto = null;
    public function __construct($app){
        $this->app = $app;
        
    }
    public function title($title){
        $this->ret["title"] = $title;
        return $this;
    }
    public function remote(){
        $r = new RemoteObject(new Device($this));
        return $r;
    }
   
    public function message($message){
        $this->ret["message"] = $message;
        return $this;
    }
    public function yes($url){
        $this->ret["yes_url"] = $url;
        return $this;
    }
    public function no($url){
        $this->ret["no_url"] = $url;
        return $this;
    }
    public function orderId($orderId){
        $this->ret["order_id"] = $orderId;
        return $this;
    }
    public function done($data = ['status' => 'success'],$goto = "HistoryPage"){
        $this->app->jsonWithResponse($data,$this->ret);
    }
    public function raw(){
        return (object) $this->ret;
    }
    public function ref($ref){
        $this->ret['REF_'] = $ref;
        return $this;
    }
    public function buttons($array){
        $this->ret['buttons'] = $array;
        return $this;
    }
    public function goto($goto){
        $this->goto = $goto;
        return $this;
    }    
    public function setRootOnPopup($page){
        $this->eval("nav",["page" => $page,"method" => "setRoot"]);
        return $this;
    }
    public function pushOnPopup($page){
        $this->eval("nav",["page" => $page,"method" => "push"]);
        return $this;
    }
    public function popOnPopup(){
        $this->eval("pop");
        return $this;
    }

    public function eval($scriptName,$vars = []){
        $script = ROOT."/plugins/Utils/src/Ref/$scriptName".".js";
        $script = file_get_contents($script);
        foreach($vars as $k => $v){
            if(is_array($v)){
                $v = json_encode($v);
            }
            $script = str_replace("%".strtoupper($k)."%",$v,$script);
        }
        $nyr = $this->remote()->eval($script);
        $this->ref($nyr);
        return $this;
    }
        
    public function evalWithData($scriptName,$data){
        $script = ROOT."/plugins/Utils/src/Ref/$scriptName".".js";
        $script = 'var data = '.json_encode($data).";\n\n".file_get_contents($script);
        
        $nyr = $this->remote()->eval($script);
        $this->ref($nyr);
        return $this;
    }
    
    public function push($uid,$goto = null){
        
        $this->app->loadModel("Notifications");
        
        $e = $this->app->Notifications->newEntity();
        $e->user_id = $uid;
        $e->title = @$this->ret['title'] ?? "";
        $e->message = @$this->ret['message'] ?? "";
        if(isset($this->ret['yes_url'])){
            $e->yes_url = $this->ret['yes_url'];
        }
        if(isset($this->ret['yes_r'])){
            $this->ret['yes_url'] = $this->ret['yes_r']->selector;
        }
        if(isset($this->ret['no_url'])){
            $e->no_url = $this->ret['no_url'];
        }
        if(isset($this->ret['order_id'])){
            $e->order_id = $this->ret['order_id'];
        }
        if(isset($this->ret['buttons'])){
            $e->buttons = json_encode($this->ret['buttons']);
        }
        if(isset($this->ret['REF_'])){
            $e->REF_=$this->ret['REF_'];
        }
        
        $saved = $this->app->Notifications->save($e);
        
        if($saved)
            $this->app->Notifications->push($saved->id);
            
        return $this;
    }
    public function getRefView($name){
        $f = ROOT."/plugins/Utils/src/Ref/View/$name.html";
        if(file_exists($f)){
            return file_get_contents($f);
        }else{
            return null;
        }
    }
    
}
/**
 * Hotpush component
 */
class HotpushComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function foo(){
        
        exit;
    }
    public function popupApp($parent){
        return new PopupsRef($parent);
    }
}
