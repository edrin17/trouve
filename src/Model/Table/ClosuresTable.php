<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\Item;


class ClosuresTable extends Table
{
    public function initialize(array $config){
        parent::initialize($config);

        $this->belongsTo('Ascendant',[
           'className' => 'Items',
           'foreignKey' => 'ascendant',
           'propertyName' => 'Ascendant',
           'bindingKey' => 'id',
        ]);
        $this->belongsTo('Descendant',[
           'className' => 'Items',
           'foreignKey' => 'descendant',
           'propertyName' => 'Descendant',
           'bindingKey' => 'id',
        ]);


    }

    public function getDirectChildren($containerId){
        $query = $this->find()->where([
            'ascendant' => $containerId,
            'depth' => 1, //1 in direct child
        ])
        ->contain(['Ascendant','Descendant']);
        //debug($directParent);
        return ($query->toArray());
    }

    public function getMainContainer(){
        $query = $this->find()->where([
            'level' => 0, //0 is golbal container
        ])
        ->first();
        //debug();die;
        return ($query);
    }

    public function getDirectParent($containerId){
        $query = $this->find()->where([
            'descendant' => $containerId,
            'depth' => 1,
        ])
        ->contain(['Ascendant','Descendant'])
        ->first();
        return ($query);
    }

    //create a new entry in the table with ascendant and child
    public function newClosure($ascendant, $descendants, $depth, $level)
    {
        $closure = $this->newEntity();
        $closure->ascendant = $ascendant;
        $closure->descendant = $descendants;
        $closure->depth = $depth;
        $closure->level = $level;
        $this->save($closure);
    }

    public function buildClosure($containerId = null, $item = null)
    {
        $ascendants = $this->find()->where([ //find all containers ascendants of the container
            'descendant' => $containerId,
            'depth >' => 0,
        ]);
        //debug($ascendants);
        //debug($ascendants->toArray());
        foreach ($ascendants as $ascendant) { //add a child for each container
            $closure = $this->newEntity();
            $closure->ascendant = $ascendant->ascendant; //it self as parent
            $closure->descendant = $item; //new item as descendant
            $closure->depth = $ascendant->depth + 1; //one more level depth because it ascendant of n-1 ascendant
            $closure->level = 1; // not top level
            //debug($closure);
            $this->save($closure);
        }
    }

    public function getAllParents($containerId){
        $MainContainerId = $this->getMainContainer();
        $MainContainerId = $MainContainerId->ascendant;
        $query = $this->find()->where([
            'descendant' => $containerId,
            'ascendant <>' => $containerId,
            'ascendant <>' => $MainContainerId,
            'level' => 1,
        ])
        ->contain(['Ascendant','Descendant']);
        return ($query);
    }
}
