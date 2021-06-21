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

    public function add($parent_id=null)
    {
        $first = $second = $third = $fourth = null;
        $containerId = $this->request->query('container_id'); //get container from request
        //$parentId = $parent1_id;


        $parents1List = $this->getParent1List(); // get lvl1 parent list
        //$first = $parents1List->first();
        $parents1List = $this->buildArray($parents1List); //add null choice to the lvl1 parent list

        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
            $this->save($item);
            //debug($item);die;
            $this->buildClosure($containerId, $item);
        }
        $this->set(compact('item','parents1List','containerId'));
    }

    protected function save($item)
    {
        $item = $this->Items->patchEntity($item, $this->request->getData());
        if ($this->Items->save($item)) {
            $this->Flash->success(__("L'objet a été sauvegardée."));
            return $this->redirect('/');
        } else {
            $this->Flash->error(__("L'objet n'a pas pu être sauvegardé ! Réessayer."));
        }
    }

    protected function buildClosure($containerId, $item)
    {
        $table = TableRegistry::getTableLocator()->get('closures');//charge la table closures
        $this->newClosure($item);
        //ajoute un entree parent avec l'id de l'item en enfant
        //ajoute update tous les ascendants du parentd direct avec un nouvel enfant
        //mettre à jour les niveaux de profondeur
    }

    protected function newClosure($item)
    {
        $table = TableRegistry::getTableLocator()->get('closures');
        $closure = $table->newEntity();
        $closure->ascendant = $item->id;
        $closure->descendant = $item->id;
        $closure->depth = 0;
        //debug($closure);die;
        $table->save($closure);
    }

    public function delete()
    {

    }

    public function edit()
    {

    }
    private function buildArray($query)
    {
        $list[0] = 'Aucun';
        foreach ($query as $item) {
            $list[$item->id] = $item->name;
        }
        return $list;
    }
    private function getParent1List()
    {
        $items = TableRegistry::getTableLocator()->get('items');
        $parents1List = $items->find()
            ->where(['parent1_id IS' => null])
            ->order(['name' => 'ASC']);
        return $parents1List;
    }
}
