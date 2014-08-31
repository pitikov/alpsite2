<?php
/** @class MemberMountaringTable
 * Виджет таблицы восхождений члена федерации
 *
 * @author Evegniy.A.Pitikov
 */
class MemberMountaringTable extends CWidget {
    
    /// @property string $member 
    public $member;
    
    /// @property boolean $editable Разрешение наа редактирование таблицы
    public $editable = false;
    

    public function init() {
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        
        /** @todo Получать список восхождений через ajax запросс. 
         * Активацию запросса повесить на JS вызов текущего расширения */
        $dataProvider = new CArrayDataProvider(array(
            array(
                'id' => '0',
                'date'=>'20.11.2009',
                'peak'=>'Elbrus',
                'route'=>'From kukurtlu',
                'diffculty'=>'4a',
                'composition'=>'Pitikov +1'
            ),
            array(
                'id' => '1',
                'date'=>'21.11.2009',
                'peak'=>'Elbrus',
                'route'=>'from Lava stream',
                'diffculty'=>'2a',
                'composition'=>'Pitikov +3'
            ),
            array(
                'id' => '2',
                'date'=>'22.11.2009',
                'peak'=>'Elbrus',
                'route'=>'Cross',
                'diffculty'=>'4a',
                'composition'=>'Shkolnikov +4'
            ),
        ),
        array(
            'pagination'=>array(
                'pageSize'=>10
            )
                ));
        
        $this->show($dataProvider);
        
        parent::init();
    }
    
    private function show($dataProvider) 
    {
        echo CHtml::tag('div', array('id'=>$this->id),'',false);
        echo CHtml::tag('h3', array(), 'Список восхождений участника');
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider, 
            'columns'=>array(
                array(
                    'name'=>'date',
                    'header'=>'дата',
                ),
                array(
                    'name'=>'peak',
                    'header'=>'на вершину',
                ),
                array(
                    'name'=>'route',
                    'header'=>'по маршруту',
                ),
                array(
                    'name'=>'diffculty',
                    'header'=>'КС'
                ),
                array(
                    'name'=>'composition',
                    'header'=>'в составе'
                ),
            ),
            ));
        echo CHtml::closeTag('div');
    }
}
