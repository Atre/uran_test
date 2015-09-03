app.factory('Categories', function ($resource) {
    return $resource('site/:method', {}, {
        query: { method: 'GET',  params: {method: '@method'}, isArray: true },
    })
});

app.factory('Category', function ($resource) {
    return $resource('site/:method', {}, {
        create: { method: 'POST',  params: {method: 'createcategory'} },
        delete: { method: 'POST',  params: {method: 'deletecategory'} },
    })
});

app.factory('Entry', function ($resource) {
    return $resource('site/:method', {}, {
        get: { method: 'GET',  params: {method: 'getentry', id: '@id'} },
        create: { method: 'POST',  params: {method: 'createentry'} },
        delete: { method: 'POST',  params: {method: 'deleteentry'} },
    })
});

app.factory('Tags', function ($resource) {
    return $resource('site/:method', {}, {
        get: { method: 'GET',  params: {method: '@method'}, isArray: true },
    })
});