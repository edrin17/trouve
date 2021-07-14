<?php
$this->assign('title',"Edition d'un objet");
?>
<div class="items form large-9 medium-8 columns content">
    <?php echo $this->Form->create($item,['controller' => 'Items', 'action' => 'edit']) ?>
    <fieldset>
        <legend><?php echo __('Ajouter un objet') ?></legend>
        <?php echo $this->Form->input('name',['label' => 'Nom']); ?>
        <?php echo $this->Form->input('container_id',['type' => 'hidden', 'value' => $containerId]); ?>
        <?php echo $this->Form->input('qty',['label' => 'Quantité']); ?>
    </fieldset>
    <?php echo $this->Form->button(__('Enregistrer')) ?>
    <?php echo $this->Form->end() ?>
</div>
