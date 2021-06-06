<?php
$this->assign('title',"Ajout d'un objet");
?>
<div class="items form large-9 medium-8 columns content">
    <?= $this->Form->create($item,['controller' => 'Items', 'action' => 'add']) ?>
    <fieldset>
        <legend><?= __('Ajouter une activité') ?></legend>
        <?= $this->Form->input('name',['label' => 'Nom']); ?>
        <?= $this->Form->input('qty',['label' => 'Quantité']); ?>
    </fieldset>
    <?= $this->Form->button(__('Enregistrer')) ?>
    <?= $this->Form->end() ?>
</div>
