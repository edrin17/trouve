<?php
    $this->assign('title',"Gestionnaire d'objets");
debug($children);
?>
<table id ="tableau" class="table">
    <thead>
        <tr>
            <th> Nom de l'objet </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
            <th class="legend"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($children as $child): ?> <!--Affiche le contenu de 'activites'  -->
        <tr>
            <td><?= h($item->name) ?></td>
            <td class="error">
            <?php echo $this->Html->link('Ajouter objet',
                ['controller' => 'Items','action' => 'add',
                    '?'=>['parent_id'=> $item->id]],
                ['class' => 'button']
                );
            ?>
            <?php echo $this->Html->link('Afficher le contenu',
                ['controller' => 'Items','action' => 'display',
                    '?'=>['parent_id'=> $item->id]],
                ['class' => 'button']
                );
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
