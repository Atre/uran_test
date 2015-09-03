app.controller("TreeController", function($scope, $window, Categories, Category, Entry, Tags) {

    $scope.init = function() {
        Categories.query({method: 'getallentries'}).$promise.then(function(data) {
            // Return entries wrapped by 'base' element
            $scope.tasks = {id: '0', items: data};
        });

        Tags.query({method: 'gettags'}).$promise.then(function(data) {
            // Return entries wrapped by 'base' element
            $scope.allTags = data;
        });
    };

    // Show/hide category controls on mouse hover
    $scope.menuDisplay = function($event) {
        $scope.content ++;
        var $el = $($event.target);
        if($event.type === 'mouseenter') {
            $el.find('[data-category-control]:first').show();
        } else if ($event.type === 'mouseleave') {
            $el.find('[data-category-control]:first').hide();
        }
    };

    // Add category
    $scope.addCategory = function($event, id) {
        var $el = $($event.target);
        catParentCat = +id;
    };

    // Add element
    $scope.addElement = function($event, id) {
        var $el = $($event.target);
        elementParentCat = +id;
    };

    // Submit add category form
    $scope.catSubmit = function() {
        console.log($scope.newCategoryName);
        if(!$scope.newCategoryName || $scope.newCategoryName === '') {
            return false;
        } else {
            Category.create({name: $scope.newCategoryName, category: catParentCat}).$promise.then(function() {
                $window.location.reload();
            });
        }
    };

    // Submit add element form
    $scope.elSubmit = function() {
        if(!$scope.newElName || $scope.newElName === '' || !$scope.newElBody || $scope.newElBody === '') {
            return false;
        } else {
            Entry.create({name: $scope.newElName, body: $scope.newElBody, category: elementParentCat, tags: $scope.tags}).$promise.then(function() {
                $window.location.reload();
            });
        }
    };

    // Removes element
    $scope.removeElement = function($event, type, id) {
        var $el = $($event.target);
        if(confirm('Are you sure?')) {
            if(type === 'category') {
                var ids = $el.closest('.list-group-item').find('[data-category-control]').map(function() {
                    if($(this).attr('data-type') === 'category')
                    {
                        return +$(this).attr('data-id');
                    }
                });
                Category.delete({id: ids});
                $window.location.reload();
            } else if(type === 'entry') {
                Entry.delete({id: id});
                $window.location.reload();
            }
        }
    };

    // Toggle menu
    $scope.toggleMenu = function($event) {
        var $el = $($event.target);
        $el.siblings('[data-collapsable]').slideToggle();
    };

    // Show contents
    $scope.showContents = function($event, type, id) {
        $event.stopPropagation();
        if(type === 'entry') {
            Entry.get({id: id}).$promise.then(function(data) {
                // TODO: rewrite with scope 2wb
                $('#content').html(data.data.body);
                $('#content-header').html(data.data.name);
                $('#tags').html(data.tags.map(function(e){return e.text}).join(',')).show();
            });
        }
    };

    // Tags autocomplete
    $scope.loadTags = function() {
        console.log($scope.allTags);
        return $scope.allTags;
    }
});