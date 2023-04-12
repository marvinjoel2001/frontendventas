$("#frmAcceso").on('submit', function(e) {
    e.preventDefault();
    var logina = $("#logina").val();
    var clavea = $("#clavea").val();

    var data = {
        "name": logina,
        "user": logina,
        "password": clavea
    };
    
    $.ajax({
        url: "https://localhost:7060/api/Sellers/login",
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(response) {
            if (response.token) {
                var token = response.token;
                // Establecer la variable de sesión mediante una solicitud AJAX a un archivo PHP
                $.post("../ajax/login.php", { nombre: data.name }, function(data) {
                    // La variable 'data' contiene la respuesta del archivo PHP
                    console.log(data);
                });
                alert("Token recibido: " + token);
                // Aquí puedes guardar el token en localStorage o en una cookie para usarlo en otras solicitudes
                $(location).attr("href","escritorio.php");
            } else {
                alert("Error: no se recibió un token");
            }
        },
        error: function(xhr, status, error) {
            alert("Error: " + error);
        }
    });
});