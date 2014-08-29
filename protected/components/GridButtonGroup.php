<?php
class GridButtonGroup extends CGridColumn {
  public $GridId;
  public $buttons = array(
      'edit'=>array(
	  'label'=>'Редактировать',
	  'img'=>'/images/edit.png',
	  'url'=>'#',
	  'confirm'=>null,
	  'action'=>null,
	  'id'=>null,
      ),
      'delete'=>array(
	  'label'=>'Удалить',
	  'img'=>'/images/delete.png',
	  'url'=>'#',
	  'confirm'=>'Удалить запись?',
	  'action'=>null,
	  'id'=>null,
      ),
      'up'=>array(
	  'label'=>'Поднять',
	  'img'=>'/images/up.png',
	  'url'=>'#',
	  'confirm'=>null,
  	  'action'=>null,
	  'id'=>null,
      ),
      'down'=>array(
	  'label'=>'Опустить',
	  'img'=>'/images/down.png',
	  'url'=>'#',
	  'confirm'=>null,
	  'action'=>null,
	  'id'=>null,
      ),
  );

  
  protected function renderDataCellContent($row, $data)
  {
      foreach($this->buttons as $key=>$button) {      
	  if (!isset($button['url'])) {
              $button['url'] = Yii::app()->createUrl($button['action'], array('id'=>$data[$button['id']]));
          }
          if (isset($button['onclick'])) {
              echo CHtml::link(CHtml::image($button['img'], 
                      $button['label'], 
                      array(
                          'key'=>$data->attributes[$button['id']],
                          'class'=>'GridButtonImage'
                          )),
                      '#',
                      array(
                          'onclick'=>$button['onclick'])
                          );
          } else {
              echo CHtml::link(CHtml::image($button['img'], 
                      $button['label'], 
                      array(
                          'key'=>$data->attributes[$button['id']],
                          'class'=>'GridButtonImage'
                          )),
                      '#',
                      array(
                          'onclick'=>"GridButtonGroupAction('{$button['url']}', '{$button['confirm']}');")
                          );
          }
      }      
      parent::renderDataCellContent($row, $data);
  }
}
?>
<script>
    function GridButtonGroupAction(url, confirmText) {
        if (confirmText==='unfefined') 
        {
            $.ajax({
                url:url,
                success:function(){
                    $('.grid-view').yiiGridView('update');
                },                    
                error:function(jqXHR, textStatus, errorThrown){
                    alert('Ошибка выполнения операции.'+'\n'+'Сервер вернул : '+errorThrown);
                }
            });
        } else {
            if (confirm(confirmText)) {
                $.ajax({
                    url:url,
                    success:function(){
                        $('.grid-view').yiiGridView('update');
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        alert('Ошибка выполнения операции.'+'\n'+'Сервер вернул : '+errorThrown);
                    }
                });
            }
        }
    };
</script>