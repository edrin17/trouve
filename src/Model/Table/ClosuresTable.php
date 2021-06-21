<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\Item;


class ClosuresTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->belongsTo('Items',[
           ['foreignKey' => 'ascendants',
           'propertyName' => 'ascendants'],
           ['foreignKey' => 'descendant',
           'propertyName' => 'descendants'],
        ]);
    }
}
