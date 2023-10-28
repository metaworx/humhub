<?php

use humhub\compat\CActiveForm;
use humhub\compat\CHtml;
use humhub\models\Setting;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('AdminModule.views_user_index', '<strong>Manage</strong> users'); ?></div>
    <div class="panel-body">
        <ul class="nav nav-pills">
            <li class="active"><a
                    href="<?php echo Url::toRoute('index'); ?>"><?php echo Yii::t('AdminModule.views_user_index', 'Overview'); ?></a>
            </li>
            <li>
                <a href="<?php echo Url::toRoute('add'); ?>"><?php echo Yii::t('AdminModule.views_user_index', 'Add new user'); ?></a>
            </li>
        </ul>
        <p />
        <p>
            <?php echo Yii::t('AdminModule.views_user_index', 'In this overview you can find every registered user and manage him.'); ?>
        </p>

        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'options' => ['width' => '40px'],
                    'format' => 'raw',
                    'value' => function($data) {
                return $data->id;
            },
                ],
                'username',
                'email',
                'profile.firstname',
                'profile.lastname',
                [
                    'attribute' => 'super_admin',
                    'label' => 'Admin',
                    'filter' => \yii\helpers\Html::activeDropDownList($searchModel, 'super_admin', array('' => 'All', '0' => 'No', '1' => 'Yes')),
                    'value' =>
                    function($data) {
                return ($data->super_admin == 1) ? 'Yes' : 'No';
            }
                ],
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'options' => ['width' => '80px'],
                    'buttons' => [
                        'view' => function($url, $model) {
                            return Html::a('<i class="fa fa-eye"></i>', $model->getUrl(), ['class' => 'btn btn-primary btn-xs tt']);
                        },
                                'update' => function($url, $model) {
                            return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['edit', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                        },
                                'delete' => function($url, $model) {
                            return Html::a('<i class="fa fa-times"></i>', Url::toRoute(['delete', 'id' => $model->id]), ['class' => 'btn btn-danger btn-xs tt']);
                        }
                            ],
                        ],
                    ],
                ]);
                ?>

                <?php
                /*
                  $this->widget('zii.widgets.grid.CGridView', array(
                  'id' => 'user-grid',
                  'dataProvider' => $model->resetScope()->search(),
                  'filter' => $model,
                  'itemsCssClass' => 'table table-hover',
                  // 'loadingCssClass' => 'loader',
                  'columns' => array(
                  array(
                  'value' => 'CHtml::image($data->profileImage->getUrl())',
                  'type' => 'raw',
                  'htmlOptions' => array('width' => '30px'),
                  ),
                  array(
                  'name' => 'username',
                  'header' => Yii::t('AdminModule.views_user_index', 'Username'),
                  'filter' => CHtml::activeTextField($model, 'username', array('placeholder' => Yii::t('AdminModule.views_user_index', 'Search for username'))),
                  ),
                  array(
                  'name' => 'email',
                  'header' => Yii::t('AdminModule.views_user_index', 'Email'),
                  'filter' => CHtml::activeTextField($model, 'email', array('placeholder' => Yii::t('AdminModule.views_user_index', 'Search for email'))),
                  ),
                  array(
                  'name' => 'super_admin',
                  'header' => Yii::t('AdminModule.views_user_index', 'Admin'),
                  'filter' => array("" => Yii::t('AdminModule.views_user_index', 'All'), 0 => Yii::t('AdminModule.views_user_index', 'No'), 1 => Yii::t('AdminModule.views_user_index', 'Yes')),
                  ),
                  array(
                  'class' => 'CButtonColumn',
                  'template' => '{view}{update}{deleteOwn}',
                  'viewButtonUrl' => 'Yii::app()->createUrl("//user/profile", array("uguid"=>$data->guid));',
                  'updateButtonUrl' => 'Yii::app()->createUrl("//admin/user/edit", array("id"=>$data->id));',
                  'htmlOptions' => array('width' => '90px'),
                  'buttons' => array
                  (
                  'view' => array
                  (
                  'label' => '<i class="fa fa-eye"></i>',
                  'imageUrl' => false,
                  'options' => array(
                  'style' => 'margin-right: 3px',
                  'class' => 'btn btn-primary btn-xs tt',
                  'data-toggle' => 'tooltip',
                  'data-placement' => 'top',
                  'title' => '',
                  'data-original-title' => Yii::t('AdminModule.views_user_index', 'View user profile'),
                  ),
                  ),
                  'update' => array
                  (
                  'label' => '<i class="fa fa-pencil"></i>',
                  'imageUrl' => false,
                  'options' => array(
                  'style' => 'margin-right: 3px',
                  'class' => 'btn btn-primary btn-xs tt',
                  'data-toggle' => 'tooltip',
                  'data-placement' => 'top',
                  'title' => '',
                  'data-original-title' => Yii::t('AdminModule.views_user_index', 'Edit user account'),
                  ),
                  ),
                  'deleteOwn' => array
                  (
                  'label' => '<i class="fa fa-times"></i>',
                  'visible' => '$data->id != Yii::app()->user->id', //cannot delete yourself
                  'imageUrl' => false,
                  'url' => 'Yii::app()->createUrl("//admin/user/delete", array("id"=>$data->id));',
                  'deleteConfirmation' => false,
                  'options' => array(
                  'class' => 'btn btn-danger btn-xs tt',
                  'data-toggle' => 'tooltip',
                  'data-placement' => 'top',
                  'title' => '',
                  'data-original-title' => Yii::t('AdminModule.views_user_index', 'Delete user account'),
                  ),
                  ),
                  ),
                  ),
                  ),
                  'pager' => array(
                  'class' => 'CLinkPager',
                  'maxButtonCount' => 5,
                  'nextPageLabel' => '<i class="fa fa-step-forward"></i>',
                  'prevPageLabel' => '<i class="fa fa-step-backward"></i>',
                  'firstPageLabel' => '<i class="fa fa-fast-backward"></i>',
                  'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
                  'header' => '',
                  'htmlOptions' => array('class' => 'pagination'),
                  ),
                  'pagerCssClass' => 'pagination-container',
                  ));
                 *
                 */
                ?>

    </div>
</div>