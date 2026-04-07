$(function () {

const urlBase = "index.php";

cargarTalleres();

function cargarTalleres() {

    $.get(urlBase,
    {
        option: "talleres_json"
    },
    function (data) {

        let html = "";

        data.forEach(t => {

            html += `
            <div class="taller-card">

                <div class="taller-title">
                    ${t.nombre}
                </div>

                <div class="taller-desc">
                    ${t.descripcion}
                </div>

                <div class="taller-cupos">
                    Cupos disponibles: ${t.cupo_disponible}
                </div>

                <button 
                    class="btn btn-primary btn-solicitar"
                    onclick="solicitar(${t.id})">
                    Solicitar inscripción
                </button>

            </div>
            `;
        });

        $("#listaTalleres").html(html);

    }, "json");
}


window.solicitar = function(id){

    $.post(urlBase,{
        option:"solicitar",
        taller_id:id
    },function(response){

        response = JSON.parse(response);

        if(response.success){
            alert("Solicitud enviada");
            cargarTalleres();
        }else{
            alert(response.error);
        }

    });

}


$("#btnLogout").click(function(){

    $.post(urlBase,{
        option:"logout"
    },function(){
        window.location="index.php?page=login"
    });

});


});