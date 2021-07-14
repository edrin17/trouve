<?php
    $this->assign('title',"Gestionnaire d'objets");
?>
<?php echo $this->Html->link('Ajouter un objet ou un conteneur',
    ['controller' => 'Items','action' => 'add',
        '?'=>['container_id'=> $containerId]],
    ['class' => 'button']
    );
?>

<?php /*echo $this->Html->link('Reset',
        ['controller' => 'Items','action' => 'populate'],
        ['class' => 'button']
    );*/
    echo' ';
?>
<?php
    echo $this->Html->link('Retour au parent',
        ['controller' => 'Items','action' => 'index',
            '?' => ['container_id' => $grandPaId]],
        ['class' => 'button']
    );
?>
<table id ="tableau" class="table">
    <thead>
        <tr>
            <th> Nom de l'objet </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
            <th class="legend"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?> <!--Affiche le contenu de 'activites'  -->
            <?php //debug($item);
                $itemId = $item->descendant;
            ?>
            <tr>
                    <td><?= h($item->Descendant->name) ?></td>
                    <td>
                    <?php echo $this->Html->link("Afficher le contenu du l'objet",
                        ['controller' => 'Items','action' => 'index',
                            '?' => ['container_id'=> $itemId]],
                            ['class' => 'button']
                        );
                    ?>
                    <?php echo $this->Html->link('Modifier',
                        ['controller' => 'Items','action' => 'edit',
                            '?' => ['container_id'=> $containerId, 'item_id' => $itemId]],
                            ['class' => 'button']
                        );
                    ?>
                    <?php
                        echo $this->Form->postLink('Supprimer',[
                            'controller' => 'Items','action' => 'delete'],
                            ['data' => ['item_id' => $itemId, 'container_id' => $containerId],
                            'confirm' => 'Êtes-vous sûr ?',
                            'class' => 'button',
                        ]);
                    ?>
                    </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
