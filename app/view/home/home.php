<?php
include_once '../layouts/header.php';
?>

<div class="conteiner" id="contein">
    chau
</div>



<script type="text/javascript">

    $(function(){
        listar()
    });

    function listar(){
        __ajax("./listar.php","").done(function(info){
            console.log(info)
        })
    }

    function __ajax(url,data){
        var ajax=$.ajax({
            "method":"POST",
            "url": url,
            "data": data
        })
        return ajax;
    }
</script>
