<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route; // We use routing API to be able to redirect URL in add() function
class ItemsController extends AppController
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
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            debug($item);
            if ($this->Items->save($item)) {
                $this->Flash->success(__("L'objet a été sauvegardée."));
                return $this->redirect('/');
            } else {
                $this->Flash->error(__("L'objet n'a pas pu être sauvegardé ! Réessayer."));
            }
        }

        $this->set(compact('item'));
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
