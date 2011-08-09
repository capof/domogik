<?php $this->pageTitle=Yii::app()->name; ?>

<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>

<?php foreach(Yii::app()->user->getFlashes() as $key => $message) {
    if ($key=='counters') {continue;}
    echo "<div class='{$key}'>{$message}</div>";
} ?>

<div id='upload' class='section'>
    <h2>Upload package</h2>
    <div class='content'>

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'packageUpload-form',
            'action'=>array('packageUpload'),
        ));?>
        <div class="row">
            <?php echo $form->labelEx($packageUpload, 'package'); ?>
            <?php echo $form->fileField($packageUpload, 'package'); ?>
            <?php echo $form->error($packageUpload, 'package'); ?>
        </div>
    
        <div class="row buttons">
            <?php echo CHtml::submitButton('Upload'); ?>
        </div>
    
        <?php $this->endWidget(); ?>
    </div>
</div>
<div id='packagesList' class='section'>
    <h2>Packages.lst</h2>
    <div class='content'>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'packagelstGenerate-form',
        'action'=>array('packagelstGenerate'),
    ));?>
    <?php echo CHtml::submitButton("Generate 'packages.lst' for :"); ?>
    <?php echo CHtml::dropDownList("package_list", null, $repositories); ?>
    <?php $this->endWidget(); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$packageslst,
	'itemView'=>'_viewRepositoryUpdate',
)); ?>
    </div>
</div>

<div id='list' class='section'>
    <h2>Packages list</h2>
    <div class='content'>
<?php
    echo CHtml::beginForm(array('site/packagesAction'));
    $formatter = new MyFormatter();
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'forms-grid',
        'dataProvider'=>$packages,
        'formatter'=>$formatter,
        'rowCssClassExpression'=>'($data["repositoryid"] == "trash" || $data["repositoryid"] == "sas")? $data["repositoryid"]: "std"',
        'columns'=>array(
            array(
                'value'=>'($data["repositoryid"] != "trash")?CHtml::checkBox("packages[" . $data["repositoryid"] . "][]", false, array("value"=>$data["filename"])):""',
                'type'=>'raw',
            ),
            'repository',
            array(
                'htmlOptions'=>array('class'=>'package'),
                'name'=>'filename',
            ),
            array('name'=>'deployed',
                'type'=>'booleanIcon',
                'htmlOptions' => array('style' => 'text-align: center;'),
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{viewpkg}',
                'buttons'=>array(
                    'viewpkg'=>array(
                        'label'=>'View',
                        'visible'=>'($data["deployed"] == 1)',
                        'url'=>'Yii::app()->createUrl("/site/packageView",array("package"=>$data["filename"], "repo"=>$data["repositoryid"]))',
                    ),                    
                ),
            ),
            'date',
            'size',
        ),
    ));
    echo CHtml::submitButton('delete selected', array('name'=>'delete'));
    echo CHtml::submitButton('deploy selected', array('name'=>'deploy'));
    echo CHtml::submitButton('undeploy selected', array('name'=>'undeploy'));
    echo CHtml::submitButton('move selected to :', array('name'=>'move'));
    echo CHtml::dropDownList("destination", null, $repositories);
    echo CHtml::endForm();
?>
    </div>
</div>