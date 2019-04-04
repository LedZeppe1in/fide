<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FishboneDiagram */

$this->title =  Yii::t('app', 'HEADER_UPDATE') . $model->name;
$this->params['breadcrumbs'][] = ['label' =>  Yii::t('app', 'NAV_DIAGRAMS'), 'url' => ['diagrams']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'HEADER_UPDATE');
?>
<div class="fishbone-diagram-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
