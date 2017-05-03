var MC_Atos = (function($, window, document, undefined){
    /**
     * set ajax load data
     * @param type
     * @param baseadmin
     * @param getlang
     * @param edit
     * @returns {string}
     */
    function setAjaxUrlLoad(baseadmin){
        return '/'+baseadmin+'/plugins.php?name=atos';
    }

    /**
     * Save
     * @param id
     * @param baseadmin
     */
    function save(baseadmin,id){
        if(id === '#forms_plugins_atos') {
            var rules = {
                merchandId: {
                    required: true
                },
                secureKey: {
                    required: true
                },
                accountType: {
                    required: true
                }
            };
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                rules: rules,
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: setAjaxUrlLoad(baseadmin),
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        beforeParams:function(){},
                        successParams:function(e){
                            $.nicenotify.initbox(e,{
                                display:true
                            });
                            window.setTimeout(function() { $(".mc-message .alert-success").alert('close'); }, 4000);
                        }
                    });
                    return false;
                }
            });
        }else if(id === '#forms_plugins_atos_payementbrand'){
            $(id).on('submit',function(event) {
                event.preventDefault();
                if (($("input[name^='brands']:checked").length)>=1) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: setAjaxUrlLoad(baseadmin),
                        typesend: 'post',
                        idforms: $(this),
                        resetform: false,
                        beforeParams: function () {
                        },
                        successParams: function (e) {
                            $.nicenotify.initbox(e, {
                                display: true
                            });
                            window.setTimeout(function () {
                                $(".mc-message .alert-success").alert('close');
                            }, 4000);
                        }
                    });
                    return false;
                }else{
                    var validator = $(id).validate();
                    validator.form();
                }
            });
        }
    }
    return {
        run:function(baseadmin){
            save(baseadmin,'#forms_plugins_atos');
            save(baseadmin,'#forms_plugins_atos_payementbrand');
        }
    }
})(jQuery, window, document);