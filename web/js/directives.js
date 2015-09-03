app.directive("tree", function($compile) {
    return {
        restrict: "E",
        scope: {
            family: '=',
            ctrl: '='
        },
        templateUrl: 'js/views/_tree.html',
        controller: 'TreeController',
        compile: function(tElement, tAttr) {
            var contents = tElement.contents().remove(),
                compiledContents;
            return function(scope, iElement, iAttr) {
                if(!compiledContents) {
                    compiledContents = $compile(contents);
                }
                compiledContents(scope, function(clone, scope) {
                    iElement.append(clone);
                });
            };
        },
    };
});

app.directive("addbasecategory", function($compile) {
    return {
        restrict: "E",
        template: '<button ng-click="addBaseCategory($event)" type="button" class="btn btn-default navbar-btn"' +
        ' data-toggle="modal" data-target="#catModal"><span class="glyphicon glyphicon-plus" aria-hidden="true">' +
        '</span></button>',
        controller: 'TreeController',
        link: function ($scope, element, attrs) {
            element.bind('click', function () {
                angular.element($('tree').find('.list-group')).append($compile("<tree></tree>")($scope));
            });
        }
    };
});

app.directive('content', function(){
    return {
        restrict: "E",
        transclude: true,
        templateUrl: 'js/views/_content.html',
        controller: 'TreeController',
    };
});