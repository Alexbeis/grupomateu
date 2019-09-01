// any CSS you require will output into a single css file (app.css in this case)
import '../css/app.css';
import '../../node_modules/bootstrap/dist/css/bootstrap.css';
import '../../node_modules/admin-lte/bower_components/font-awesome/css/font-awesome.min.css';
import '../../node_modules/admin-lte/bower_components/Ionicons/css/ionicons.min.css';
import '../../node_modules/admin-lte/dist/css/AdminLTE.min.css';
import '../../node_modules/admin-lte/dist/css/skins/skin-blue.min.css';
import '../../node_modules/admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css';
import '../../node_modules/admin-lte/bower_components/select2/dist/css/select2.min.css';

const $ = require('jquery');
global.$ = global.jquery = $;

//import 'bootstrap';
import '../../node_modules/bootstrap/dist/js/bootstrap.js';
import '../../node_modules/admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js';
import '../../node_modules/datatables.net-responsive/js/dataTables.responsive.min.js';
import '../../node_modules/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js';
import '../../node_modules/admin-lte/bower_components/jquery-ui/jquery-ui.js';
import '../../node_modules/admin-lte/dist/js/adminlte.js';
import '../../node_modules/admin-lte/plugins/iCheck/icheck.js';
import '../../node_modules/admin-lte/bower_components/select2/dist/js/select2.min.js';


// Custom js
import './shared/AjaxCall.js';
import './shared/ChartGenerator';
import './dashboard/GMStatistics.js';
import './dashboard/GMDashboard.js';
import './explotations/GMExplotations.js';
import './explotations/GMExplotation.js';
import './explotations/GMGroup.js';
import './configuration/GMConfiguration.js';
import './animals/GMAnimals.js';
import './registers/GMRegisters.js';





