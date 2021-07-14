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
    public function index()
    {
        $closures = TableRegistry::getTableLocator()->get('closures');
        //debug($closures);die;

        $container = $closures->getMainContainer(); //try getting main container from database
        if (is_null($container)) { //if database empty
            $this->populate();
            $container = $closures->getMainContainer();
            $containerId = $container->ascendant; //get main container
        }else {
            $containerId = $container->ascendant; //get main container
        }

        $requestId = $this->request->getQuery('container_id'); //try getting container_id
        if (!is_null($requestId)) { //if container requested URL get the corresponding closure
            $container = $closures->find()
                ->where([
                    'ascendant' => $requestId,
                    'descendant' => $requestId,
                    'depth' => 0,
                ])
                ->first();
            $containerId = $container->ascendant; //set containerId for the view
        }
        //debug($containerId);

        $items = $closures->getDirectChildren($container->ascendant);
        if (is_null($items) || $items == []) {
            $this->Flash->success('Le conteneur est vide');
        }

        $grandPa = $closures->getDirectParent($container->ascendant); //try getting $grandPa for "Previous button"
        if (!is_null($grandPa) || !$grandPa == [] ) {
            $grandPaId = $grandPa->ascendant;
        }else {                                                 //$grandPa is MainContainer
            $grandPaId = $closures->getMainContainer();
            $grandPaId = $container->ascendant; //get main container
        }
        //debug($grandPa);
        $this->set(compact('items','containerId','grandPaId'));
        //debug($test);die;
    }

    public function add()
    {
        $itemLvl = 1;
        $closures = TableRegistry::getTableLocator()->get('closures');

        $containerId = $this->request->query('container_id'); //get container from welcome.ctp
        $item = $this->Items->newEntity(); //create the new entitiy to store inside the data
        $closureDepth = 0;

        if ($this->request->is('post')) { //if submitted
            //items database part
            $containerId = $this->request->getData('container_id');
            $item->qty = $this->request->getData('qty');
            $item->name = $this->request->getData('name');
            $this->save($item, $containerId); //store data from the item

            $closures->newClosure($item->id, $item->id, $closureDepth, $itemLvl); //build itself
            $closureDepth = 1; //since it's a child set it to 1
            $closures->newClosure($containerId, $item->id, $closureDepth, $itemLvl); //build direct ascendant relation
            $closures->buildClosure($containerId, $item->id); //build other ascendants relations

        }
        $this->set(compact('item','containerId'));
    }

    protected function save($item)
    {
        $item = $this->Items->patchEntity($item, $this->request->getData());
        if ($this->Items->save($item)) {
            $this->Flash->success(__("L'objet a été sauvegardée."));
            return $this->redirect([
                'controller' => 'Items',
                'action' => 'index',
                '?' => [
                    'container_id' => $this->request->getData('container_id')
                ],
            ]);
        } else {
            $this->Flash->error(__("L'objet n'a pas pu être sauvegardé ! Réessayer."));
        }
    }


    public function delete()
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemId = $this->request->getData('item_id');
        $containerId = $this->request->getData('container_id');

        $closures = TableRegistry::getTableLocator()->get('closures');

        $children = $closures->getDirectChildren($itemId);
        //debug($children); die;
        if (is_null($children) || !$children == []) {
            $this->Flash->error('Le conteneur contient des éléments');
            return $this->redirect([
                'controller' => 'Items',
                'action' => 'index',
                '?' => [
                    'container_id' => $containerId
                ],
            ]);
        }else{
            $itemId = $this->request->getData('item_id');
            $containerId = $this->request->getData('container_id');
            //debug($this->request->getData());
            //debug($itemId);die;
            $item = $this->Items->get($itemId);
            //debug($item);die;
            if ($this->Items->delete($item)) {
                $this->Flash->success(__('L\'article {0} a été supprimé.', $item->name));
                return $this->redirect([
                    'controller' => 'Items',
                    'action' => 'index',
                    '?' => [
                        'container_id' => $containerId
                    ],
                ]);
            }
        }
        //unset($itemId);
    }

    public function edit($item = null)
    {
        $itemLvl = 1;
        $closures = TableRegistry::getTableLocator()->get('closures');
        $closureDepth = 0;
        $containerId = $this->request->query('container_id'); //get container from request

        if ($this->request->is('put') == false) {
            $itemId = $this->request->query('item_id'); //get container from request
            $item = $this->Items->get($itemId); //get entitiy
        }

        if ($this->request->is('put')) { //if submitted
            $containerId = $this->request->data('container_id');
            $item = $this->Items->get($item);
            $this->save($item); //store data from the item

            $closures->newClosure($item->id, $item->id, $closureDepth, $itemLvl); //build itself
            $closureDepth = 1; //since it's a child set it to 1
            $closures->newClosure($containerId, $item->id, $closureDepth, $itemLvl); //build direct ascendant relation
            $closures->buildClosure($containerId, $item->id); //build other ascendants relations
        }
        $this->set(compact('item','containerId'));
    }


    public function populate()
    {
        $containerId = $this->Items->createGlobalContainer(); //createGlobalContainer and get Id from it;

        $closures = TableRegistry::getTableLocator()->get('closures'); //load ClosuresTable
        $closures->newClosure($containerId, $containerId, 0 , 0); //build newClosure on containerId




        return $this->redirect([
            'controller' => 'Items',
            'action' => 'index']);
    }

}
