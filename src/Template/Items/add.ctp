<?php
$this->assign('title',"Ajout d'un objet");
?>
<div class="items form large-9 medium-8 columns content">
    <?php echo $this->Form->create($item,['controller' => 'Items', 'action' => 'add']) ?>
    <fieldset>
        <legend><?php echo __('Ajouter une activité') ?></legend>
        <?php echo $this->Form->input('name',['label' => 'Nom']); ?>
        <?php echo $this->Form->input('container_id',['type' => 'hidden', 'containerId' => '$containerId']); ?>
        <?php echo $this->Form->input('qty',['label' => 'Quantité']); ?>
    </fieldset>
    <?php echo $this->Form->button(__('Enregistrer')) ?>
    <?php echo $this->Form->end() ?>
</div>
