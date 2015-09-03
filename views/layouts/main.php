<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="app">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Pace settings -->
    <script>
        paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};
    </script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container-fluid" ng-controller="TreeController" ng-init="init()">
    <!-- Navbar -->
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default navbar-fixed-top">
                <addbasecategory></addbasecategory>
            </nav>
        </div>
    </div>

    <!-- Main -->
    <div class="row">
        <!-- Side menu -->
        <div class="col-md-3 col-sm-12" data-tree-container>
            <tree family="tasks"></tree>
        </div>
        <!-- Content -->
        <div class="col-md-9 col-sm-12" ng-model="content">
            <content></content>
        </div>
    </div>

    <!-- Modal for document -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">New element</h4>
                </div>
                <div class="modal-body">
                    <form ng-submit="elSubmit()">
                        <div class="form-group">
                            <label for="document-name">Name</label>
                            <input type="text" class="form-control" id="document-name" ng-model="newElName">
                        </div>
                        <div class="form-group">
                            <label for="document-body">Body</label>
                            <textarea class="form-control" rows="6" id="document-body" ng-model="newElBody"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <tags-input ng-model="tags">
                                <auto-complete source="loadTags($query)"></auto-complete>
                            </tags-input>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="elSubmit()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal for category-->
    <div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="catModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="catModalLabel">New category</h4>
                </div>
                <div class="modal-body">
                    <form ng-submit="catSubmit()">
                        <div class="form-group">
                            <label for="document-name">Category name</label>
                            <input type="text" class="form-control" id="document-name" ng-model="newCategoryName">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="catSubmit()">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
