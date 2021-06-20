<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
class ItemsManagersController extends AppController
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
    }

    public function welcome($containerId = null)
    {
        $items = TableRegistry::getTableLocator()->get('items'); //load table $items
        $items = $items->find(); //build query for table $items

        $this->set(compact('items')); //send data to view
    }

    //Get immediate children from the selected container
    //@containerId is the id of the selected container
    public function display($containerId = null)
    {
        //get container's Id
        //get direct children
        if ($this->request->is('post')) {
            $containerId = $this->request->getData();
            $descendants = TableRegistry::getTableLocator()->get('closures');
            $children = $descendants->find()
                ->where([
                    'ascendants' => $containerId,
                    'depth' => 1,
                ])
                ->contain('Items');
        }

        $this->set(compact('children'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            debug($this->request->getData());die;
            if ($items->save($activite)) {
                $this->Flash->success(__("L'objet a été sauvegardée."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("L'objet n'a pas pu être sauvegardé ! Réessayer."));
            }
        }
        $this->set(compact('entity'));
        $this->set('_serialize', ['entity']);
    }

    public function delete()
    {

    }

    public function edit()
    {

    }
    public function updateClosure()
    {

    }
    public function getAscendants()
    {

    }
    public function getDescendants()
    {

    }
}
