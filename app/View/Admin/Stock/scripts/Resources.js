/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var ResourceConfigController = (function () {
        function ResourceConfigController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.save = function () {
                _this.$scope.config.save(_this.gettext('Resource saved successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { types: ['fonts', 'videos', 'music', 'sfx'] };
            $scope.config = $scope.configs[0] || $scope.configs.create().attr('type', 'resource').attr('data_json', {});
            $scope.settings = $scope.config.attr('data_json');
            $scope.settings.resources = angular.isObject($scope.settings.resources) ? $scope.settings.resources : {};
        }
        return ResourceConfigController;
    }());
    Admin.ResourceConfigController = ResourceConfigController;
    angular.module('resourceConfigApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('resourceConfigController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResourceConfigController]);
})(Admin || (Admin = {}));
