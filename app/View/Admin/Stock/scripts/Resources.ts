/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class ResourceConfigController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = {types: ['fonts', 'videos', 'music', 'sfx']};
            $scope.config = $scope.configs[0] || $scope.configs.create().attr('type', 'resource').attr('data_json', {});
            $scope.settings = $scope.config.attr('data_json');
            $scope.settings.resources = angular.isObject($scope.settings.resources) ? $scope.settings.resources : {};
        }

        save = () => {
            this.$scope.config.save(this.gettext('Resource saved successfully'));
        };
    }

    angular.module('resourceConfigApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('resourceConfigController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResourceConfigController]);
}
