<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\Item;


class ItemsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->HasMany('Ascendants',[
           'className' => 'Items',
           'foreignKey' => 'ascendant',
           'propertyName' => 'Ascendant',
           'binding' => 'id',
        ]);

        $this->HasMany('Descendants',[
           'className' => 'Items',
           'foreignKey' => 'descendant',
           'propertyName' => 'Descendants',
           'binding' => 'id',
       ]);
    }
    public function createGlobalContainer()
    {
        $items = $this->find();
        foreach ($items as $item) {
            $this->delete($item);
        }
        $item = $this->newEntity();
        $item->name = 'Niveau 0';
        $item->qty = 0;
        $this->save($item);
        return ($item->id);
    }
}
