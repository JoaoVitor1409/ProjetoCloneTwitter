$(document).ready(function(){
    $(".bUsu").click(function(){
        var dados = $(".pForm").serialize();

        $.ajax({
            url: "/pesquisa",
            method: "POST",
            data: dados,
            dataType: "json",
            success: function(result){
                $(".listaUsu").empty();
                for (let i = 0; i < result[1].length; i++) {  
                    if(result[0]['logado'] != result[1][i]['UsuarioID']){                        
                        $(".listaUsu").append(
                            '<div class="row mb-2">',
                                 '<div class="col">',
                                     '<div class="card">',
                                         '<div class="card-body">',
                                             '<div class="row">',
                                                 '<div class="col-md-6">',
                                                     result[1][i]['UsuarioNome'],
                                                 '</div>',                                        
                                                 '<div class="col-md-6 d-flex justify-content-end">',
                                                     '<div>',
                                                         '<a href="/seguir?id='+ result[1][i]['UsuarioID'] +'" class="btn btn-success">Seguir</a>',
                                                         '<a href="/deixarSeguir?id='+ result[1][i]['UsuarioID'] +'" class="btn btn-danger">Deixar de seguir</a>',
                                                     '</div>',
                                                 '</div>',
                                             '</div>',
                                         '</div>',
                                     '</div>',
                                 '</div>',
                            '</div>'
                        )
                    }
                }
            },
            error: function(error){
                console.log(error);
            }
        });

        return false;
    });
});