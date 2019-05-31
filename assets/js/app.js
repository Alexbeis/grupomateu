// any CSS you require will output into a single css file (app.css in this case)
import '../css/app.css';
import '../../node_modules/bootstrap/dist/css/bootstrap.css';
import '../../node_modules/admin-lte/bower_components/font-awesome/css/font-awesome.min.css';
import '../../node_modules/admin-lte/bower_components/Ionicons/css/ionicons.min.css';
import '../../node_modules/admin-lte/dist/css/AdminLTE.min.css';
import '../../node_modules/admin-lte/dist/css/skins/skin-blue.min.css';
//import '../../node_modules/alertifyjs/build/css/themes/bootstrap.min.css';

const $ = require('jquery');
global.$ = global.jquery = $;

//import 'bootstrap';
import '../../node_modules/bootstrap/dist/js/bootstrap.js';
import '../../node_modules/admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.js';
import '../../node_modules/admin-lte/bower_components/datatables.net/js/jquery.dataTables.js';
import '../../node_modules/admin-lte/bower_components/jquery-ui/jquery-ui.js';
import '../../node_modules/admin-lte/dist/js/adminlte.js';

// Custom js
import './dashboard/GMDashboard.js';
import './explotations/GMExplotations.js';





