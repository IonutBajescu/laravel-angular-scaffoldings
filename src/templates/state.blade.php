'use strict';

angular.module('app')
    .config(['$stateProvider', function ($stateProvider) {

        $stateProvider
            .state('{{$state}}', {
@if($controllerOption)
                controller: '{{$controller}}',
@endif
@if($templateOption)
                templateUrl: '{{$path}}/{{$name}}.html',
@else
                template: '<ui-view></ui-view>',
@endif
@if($abstractOption)
                abstract: true,
@endif
                url: '/{{$name}}'
            });
    }]);
