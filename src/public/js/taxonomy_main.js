$(document).ready(function () { 

    $('#Animalia_jstree').jstree(
    {
        "core" : {
            "animation" : 0,
            "check_callback" : true,
            "themes" : { "icons" : true }
        },
        "checkbox" : {
            "keep_selected_style" : false,
            "three_state" : false,
            "cascade" : 'down'
        },
        "plugins" : [ "checkbox"],
    });

    $('#Plantae_jstree').jstree(
    {
        "core" : {
            "animation" : 0,
            "check_callback" : true,
            "themes" : { "icons" : true }
        },
        "checkbox" : {
            "keep_selected_style" : false,
            "three_state" : false,
            "cascade" : 'down'
        },
        "plugins" : [ "checkbox"],
    });

    var elem_alp = document.querySelector('.js-switch-alp');
    var switchery_alp = new Switchery(elem_alp, { secondaryColor: '#ff0000' });

    var elem_con = document.querySelector('.js-switch-con');
    var switchery_con = new Switchery(elem_con, { secondaryColor: '#ff0000' });

    var elem_med = document.querySelector('.js-switch-med');
    var switchery_med = new Switchery(elem_med, { secondaryColor: '#ff0000' });

    var elem_mmed = document.querySelector('.js-switch-mmed');
    var switchery_mmed = new Switchery(elem_mmed, { secondaryColor: '#ff0000' });    

    //var elem_nd = document.querySelector('.js-switch-nd');
    //var switchery_nd = new Switchery(elem_nd, { secondaryColor: '#ff0000' });

    var elem_status_fv = document.querySelector('.js-switch-status-fv');
    var switchery_status_fv = new Switchery(elem_status_fv, { secondaryColor: '#ff0000' });

    var elem_status_u1 = document.querySelector('.js-switch-status-u1');
    var switchery_status_u1 = new Switchery(elem_status_u1, { secondaryColor: '#ff0000' });

    var elem_status_u2 = document.querySelector('.js-switch-status-u2');
    var switchery_stauts_u2 = new Switchery(elem_status_u2, { secondaryColor: '#ff0000' });

    var elem_status_xx = document.querySelector('.js-switch-status-xx');
    var switchery_status_xx = new Switchery(elem_status_xx, { secondaryColor: '#ff0000' });

});
		 
