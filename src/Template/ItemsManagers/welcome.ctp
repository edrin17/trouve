<?php
$this->assign('title',"Gestionnaire d'objets");
?>
<table id ="tableau" class="table">
    <thead>
        <tr>
            <th> Nom de l'objet </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
            <th class="legend"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($query as $item): ?> <!--Affiche le contenu de 'activites'  -->
        <tr>
            <td><?= h($item->name) ?></td>
            <td class="error">
            <!-- Affiche des urls/boutons et de leurs actions -->
            <p>
                <?= $this->Html->link(__('Voir'), ['action' => 'view', $item->id]); ?>
                <?= $this->Html->link(__('Editer'), ['action' => 'edit', $item->id]); ?>
                <?= $this->Form->postLink(__('Supprimer'),
                    ['action' => 'delete', $item->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $item->id)]); ?>
            </p>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
