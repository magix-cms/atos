{script src="/{baseadmin}/min/?f=plugins/{$pluginName}/js/admin.js" concat={$concat} type="javascript"}
<script type="text/javascript">
    $(function(){
        if (typeof MC_Atos == "undefined"){
            console.log("MC_Atos is not defined");
        }else{
            MC_Atos.run(baseadmin);
        }
    });
</script>