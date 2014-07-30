<?php
/** @brief Конфигурация менеджера аутенфикации */
    return array(
        'guest'=> array(
            'type'=>CAuthItem::TYPE_ROLE,
            'description'=>'Guest',
            'bizRule'=>null,
            'data'=>null,
        ),
        'user'=> array(
            'type'=>CAuthItem::TYPE_ROLE,
            'description'=>'User',
            'children'=>array(
                'guest',
            ),
            'bizRule'=>null,
            'data'=>null,
        ),
        'fapo'=> array(
            'type'=>CAuthItem::TYPE_ROLE,
            'description'=>'Federation member',
            'children'=>array(
                'user',
            ),
            'bizRule'=>null,
            'data'=>null,
        ),
        'admin'=> array(
            'type'=>CAuthItem::TYPE_ROLE,
            'description'=>'Site administrator',
            'children'=>array(
                'user',
            ),
            'bizRule'=>null,
            'data'=>null,
        ),
        'fapoadmin'=> array(
            'type'=>CAuthItem::TYPE_ROLE,
            'description'=>'Administrator & Federation member',
            'children'=>array(
                'fapo','admin'
            ),
            'bizRule'=>null,
            'data'=>null,
        ),
    );
?>