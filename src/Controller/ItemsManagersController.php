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

    public function welcome()
    {
        $items = TableRegistry::getTableLocator()->get('items');
        $query = $items->find();
        $this->set(compact('query'));
    }

    public function add()
    {
        $items = TableRegistry::getTableLocator()->get('Items');

        $entity = $items->newEntity();

        if ($this->request->is('post')) {
            $activite = $items->patchEntity($entity, $this->request->getData());
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
