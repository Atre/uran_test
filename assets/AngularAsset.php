<?php

namespace app\assets;


use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $js = [
        'jquery/dist/jquery.js',
        'angular/angular.js',
        'angular-route/angular-route.js',
        'angular-strap/dist/angular-strap.js',
        'angular-resource/angular-resource.js',
        'ng-tags-input/ng-tags-input.js',
        'bootstrap/dist/js/bootstrap.js',
        'https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js',
    ];
    public $css = [
        'bootstrap/dist/css/bootstrap.css',
        'ng-tags-input/ng-tags-input.css',
        'https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-minimal.css',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}