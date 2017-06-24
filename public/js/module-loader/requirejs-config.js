requirejs.config({
  paths:{
    // jQuery
    'jquery': '/assets/jquery/dist/jquery.min',

    // AngularJs
    'angular': '/assets/angular/angular.min',
    // 'angular':'http://localhost/sims/assets/angular/angular.min',
    'angular-route': '/assets/angular-route/angular-route.min',
    'angular-block-ui':'/assets/angular-block-ui/dist/angular-block-ui.min',
    'angular-animate':'/assets/angular-animate/angular-animate.min',
    'angular-sanitize':'/assets/angular-sanitize/angular-sanitize.min',
    'angular-ui-select':'/assets/angular-ui-select/dist/select.min',

    // Bootstraps
    'bootstrap':'/assets/bootstrap/dist/js/bootstrap.min',
    'bootstrap-progressbar':'/assets/bootstrap-progressbar/bootstrap-progressbar.min',
    'bootstrap-wysiwyg': '/assets/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min',
    'ui.bootstrap': '/assets/others/js/ui-bootstrap-tpls-2.5.0.min',

    // Plugins
    'icheck' :'/assets/iCheck/icheck.min',
    'jquery-smartwizard': '/assets/jQuery-Smart-Wizard/js/jquery.smartWizard',
    'jquery.hotkeys' : '/assets/jquery.hotkeys/jquery.hotkeys',
    'google-code-prettify': '/assets/google-code-prettify/src/prettify',
    'jquery.tagsinput': '/assetsjquery.tagsinput/src/jquery.tagsinput',
    'switchery': '/assets/switchery/dist/switchery.min',
    'select2':'select2/dist/js/select2.full.min',

    // lib
    'fastclick': '/assets/fastclick/lib/fastclick',

    // js
    'datepicker': '/assets/js/datepicker/daterangepicker',

    // customs
    'custom' :'/assets/custom/js/custom.min',


    'alasql' :'/assets/alasql/alasql.min',
    'xlsx.core' :'/assets/alasql/xlsx.core.min',
  },
  shim:{

    'jquery' : {
      exports:'$'
    },
    'bootstrap' : {
      deps:['jquery']
    },
    'custom' : {
      deps:['jquery']
    },
    // AngularJS
    'angular':{
      exports: 'angular',
      deps:['jquery']
    },
    'angular-route':{
      deps:['angular']
    },
    'angular-block-ui':{
      deps:['angular']
    },
    'angular-animate':{
      deps:['angular']
    },
    'angular-sanitize':{
      deps:['angular']
    },
    'angular-ui-select':{
      deps:['angular','angular-sanitize']
    },
    // plugins
    'jquery-smartwizard':{
      deps:['jquery','bootstrap','fastclick']
    },
    'switchery':{
      deps:['jquery','bootstrap','icheck']
    },
    // bootstrap
    'ui.bootstrap':{
      deps:['angular']
    }
  }
});
