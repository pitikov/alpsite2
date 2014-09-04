<?php
/**
* @file GuideController.php
* @class GuideController
* Контроллер классификатора и описаний маршрутов
*
* @author Питиков Евгений <pitikov@yandex.ru>
*/
class GuideController extends Controller {

    public function init() {
        if (Yii::app()->request->isAjaxRequest) {
            parent::init();
        } else {
            throw new CHttpException(500, "Разрешен только AJAX запрос.");
        }
    }
    
    public function actionGetregions() {
        $regionList = Region::model()->findAll(array('order'=>'title asc'));
        $regions = array();
        foreach ($regionList as $region) {
            $regions[] = array('id'=>$region->id, 'title'=>$region->title, 'description'=>$region->description);
        } echo json_encode($regions);
    }
    
    public function actionGetsubregions() {
        $subregionList = Subregion::model()->findAll(
                array(
                    'condition'=>'region=:Region',  
                    'order'=>'title asc', 
                    'params'=>array(':Region'=>$_POST['regionId'])
                    )
                );
        $subregions = array();
        foreach ($subregionList as $subregion) {
            $subregions[] = array(
                'id'=>$subregion->id, 
                'title'=>$subregion->title, 
                'description'=>$subregion->description, 
                'region'=>$subregion->region
                    );
        } echo json_encode($subregions);   
    }
    
    public function actionGetmountains() {
        $mountainList = Mountain::model()->findAll(
                array(
                    'condition'=>'subregion=:SubRegion',  
                    'order'=>'title asc', 
                    'params'=>array(':SubRegion'=>$_POST['subregionId'])
                    )
                );
        $mountains = array();
        foreach ($mountainList as $mountain) {
            $mountains[] = array(
                'id'=>$mountain->id, 
                'title'=>$mountain->title, 
                'description'=>$mountain->description, 
                'subregion'=>$mountain->subregion, 
                'height'=>$mountain->height,
                'lon'=>$mountain->location_lng,
                'lat'=>$mountain->location_lat,
                );
        }
        echo json_encode($mountains);
    }
    
    public function actionGetroutes() {
        $dataProvider = new CActiveDataProvider('Route', array(
            'criteria'=>array(
                'condition'=>"mountain=".$_POST['mountainId'],
                'order'=>'title asc'
                ),
            ));
        $addRoute = CHtml::image('/images/new.png', 'Зарегистрировать маршрут', array(
                'onclick'=>"addRoute({$_POST['mountainId']});",
                'style'=>'cursor:pointer'
            ));
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider'=>$dataProvider,
            'columns'=>array(
                array(
                    'header'=>'маршрут',
                    'value'=>'$data->title'
                    ),
                array(
                    'header'=>'высота',
                    'value'=>'$data->Mountain->height'
                    ),
                array(
                    'header'=>'КС',
                    'value'=>'$data->difficulty'
                    ),
                array(
                    'header'=>'тип',
                    'value'=>'$data->type'
                    ),
                array(
                    'header'=>'зимний',
                    'value'=>'$data->winter?"*":""'
                    ),
                array(
                    'header'=>'автор',
                    'value'=>'$data->author'
                    ),
                array(
                    'header'=>'год',
                    'value'=>'$data->year'
                    ),
                ),
            'id'=>'route-list-from-mountain_'.$_POST['mountainId'],
            'emptyText'=>'нет зарегестрированных маршрутов '.$addRoute,
            'summaryText'=>'Найденно {count} маршрутов '.$addRoute,
        ));
    }
    
    public function actionRoute() {
        $route = Route::model()->findByPk($_POST['routeId']);
        if (sizeof($route)==0) {
            throw new CHttpException(404, "Маршрут с номером {$_POST['routeId']} не найден");
        } else {
            /// @todo Send route detail
        }
    }
    
    public function actionAddregion() {
        $model= new Region();
        $model->title = $_GET['region'];
        if ($model->validate()) {
            if ($model->save()) {
                echo 'Ok';
            }
        } else {
            throw new CHttpException(500, 'Ошибка валидации');
        }
    }
    
    public function actionAddsubregion() {
        $model = new Subregion();
        $model->region = $_GET['region'];
        $model->title = $_GET['subregion'];
        if ($model->validate()) {
            if ($model->save()) {
                echo json_encode(array('subregion'=>$model->id));
            }
        } else {
            throw new CHttpException(500, 'Ошибка валидации');
        }
    }
    
}
