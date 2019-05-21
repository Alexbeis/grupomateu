// any CSS you require will output into a single css file (app.css in this case)
import '../css/app.css';
import '../../node_modules/bootstrap/dist/css/bootstrap.css';
import '../../node_modules/admin-lte/bower_components/font-awesome/css/font-awesome.min.css';
import '../../node_modules/admin-lte/bower_components/Ionicons/css/ionicons.min.css';
import '../../node_modules/admin-lte/dist/css/AdminLTE.min.css';

const $ = require('jquery');
global.$ = global.jquery = $;

import 'bootstrap';
import '../../node_modules/admin-lte/bower_components/jquery-ui/jquery-ui.js';
import '../../node_modules/admin-lte/dist/js/adminlte.js';

// Custom js
import './gm.js';



console.log('Hello Webpack Encore!!!!!!! Edit me in assets/js/app.js');

