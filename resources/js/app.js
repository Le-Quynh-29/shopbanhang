window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.moment = require('moment/moment');

    require('./bootstrap');
    require('jquery-ui');
    require('jquery-blockui');
    $.blockUI.defaults.baseZ = 3333;
    $.blockUI.defaults.css = {
        padding: 0,
        margin: 0,
        width: '30%',
        top: '40%',
        left: '35%',
        textAlign: 'center',
        cursor: 'wait'
    };
} catch (e) {}

import 'jquery-ui/ui/widgets/autocomplete';
import 'jquery-ui/ui/widgets/datepicker';
import 'jquery-ui/ui/i18n/datepicker-vi';
import 'jquery-ui/ui/widgets/draggable';
import 'jquery-ui/ui/widgets/droppable';
import 'jquery-ui/ui/widgets/selectable';
import 'jquery-ui/ui/widgets/selectmenu';
import 'jquery-ui/ui/widgets/sortable';
import 'jquery-ui/ui/widgets/slider';
import 'jquery-datetimepicker/build/jquery.datetimepicker.full.js';
