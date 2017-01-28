<div class="content-wrapper ng-cloak" ng-app="resourceConfigApp" ng-controller="resourceConfigController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1>
                <span translate="">Resource settings</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-cog"></i> <span translate="">Resource settings</span></li>
            </ol>
        </section>

        <section class="content">
            <form class="form-horizontal" name="resourceForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{resourceForm.$valid && 'success' || 'danger'}}">
                    <div class="box-body">
                        <div ng-repeat="type in data.types" ng-include="'/resources.html'">
                        </div>
                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="">Update settings</span>
                                    <i class="fa fa-fw fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <script type="text/ng-template" id="/resources.html">
        <div ng-init="settings.resources[type] = settings.resources[type] || {}; settings.resources[type].urls = settings.resources[type].urls || ['']">
            <legend>{{type | ucfirst}} <span translate="">resources</span></legend>

            <div class="form-group" ng-repeat="url in settings.resources[type].urls track by $index">
                <label class="col-sm-3 control-label" ng-show="!$index"><span translate="">Full bucket path:</span></label>
                <div class="col-sm-8 {{$index && 'col-sm-offset-3' || ''}}">
                    <input type="url" class="form-control" placeholder="https://s3.amazonaws.com/bucket/folder/path" ng-model="settings.resources[type].urls[$index]" ng-required="true">
                </div>
                <div class="col-sm-1"><a href="" ng-click="settings.resources[type].urls.splice($index, 1)" ng-show="!!$index"><sup tooltip="remove"><i class="fa fa-times"></i></sup></a></div>
            </div>

            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <p class="help-block">
                        <button type="button" class="btn btn-flat btn-default btn-sm" ng-click="settings.resources[type].urls.push('')">
                            <i class="fa fa-plus-circle"></i> <span translate="">Add another URL</span>
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </script>
</div>

