<?php
namespace Utils\Controller;

use Utils\Controller\AppController;

/**
 * Sync Controller
 *
 *
 * @method \Utils\Model\Entity\Sync[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SyncController extends AppController
{

    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($model)
    {
        $sync = $this->paginate($this->$model);

        $this->json($sync);
    }

    /**
     * View method
     *
     * @param string|null $id Sync id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($model, $id = null)
    {
        $sync = $this->$model->get($id, [
            'contain' => []
        ]);

        $this->json($sync);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($model)
    {
    
        if ($this->request->is('post')) {
            $sync = $this->$model->newEntity();
            $sync = $this->$model->patchEntity($sync, $this->request->getData());
            $ret = $this->$model->save($sync);
            $this->json($ret);
        }
        $this->json([]);
    
    }

    /**
     * Edit method
     *
     * @param string|null $id Sync id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($model,$id = null)
    {
        $sync = $this->$model->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sync = $this->$model->patchEntity($sync, $this->request->getData());
            $this->json($this->$model->save($sync));
        }
        $this->json([]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sync id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($model,$id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sync = $this->$model->get($id);
        $this->json($this->$model->delete($sync));
    }
}
