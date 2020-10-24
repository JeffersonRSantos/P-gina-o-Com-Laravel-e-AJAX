<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Pagina de Produtos</title>
    <style>
        body {
          padding: 20px;
        }
        .navbar {
          margin-bottom: 20px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

  <div class="container">
    <div class="card text-center">
      <div class="card-header">
       	Tabela de Clientes 
      </div>
      <div class="card-body">
        <h5 class="card-title" id="cardtitle"></h5>

        <table class="table table-hover" id="tabelaClientes">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nome</th>
              <th scope="col">Sobrenome</th>
              <th scope="col">Email</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="card-footer">

        <nav id="paginationNav">
          <ul class="pagination">
          </ul>
        </nav>
        
      </div>
    </div>

  </div>

  <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

  <script type="text/javascript">
    
    $(function(){
        carregarClientes(1);
    });

    function carregarClientes(pagina) {
        $.get('/json',{page: pagina}, function(resp) {
          //remove qualquer conteúdo na tabela
          $("#tabelaClientes>tbody>tr").remove();
          //passa por todos os dados
          for(i=0;i<resp.data.length;i++) {
            //imprimi os dados na tabela
            $("#tabelaClientes>tbody").append(
              '<tr>' +
              '<th scope="row">' + resp.data[i].id + '</th>' +
              '<td>' + resp.data[i].nome + '</td>' +
              '<td>' + resp.data[i].sobrenome + '</td>' +
              '<td>' + resp.data[i].email + '</td>' +
              '</tr>'
            );
          }
            montarPaginator(resp);
            $("#paginationNav>ul>li>a").click(function(){
                // console.log($(this).attr('pagina') );
                carregarClientes($(this).attr('pagina'));
            })
            $("#cardtitle").html( "Exibindo " + resp.per_page + 
                " clientes de " + resp.total + 
                " (" + resp.from + " a " + resp.to +  ")" );
        }); 
    }

    function montarPaginator(data) {
        
        $("#paginationNav>ul>li").remove();

        $("#paginationNav>ul").append(
            getPreviousItem(data)
        );
        
        n = 10;
        
        if (data.current_page - n/2 <= 1)
            inicio = 1;
        else if (data.last_page - data.current_page < n)
            inicio = data.last_page - n + 1;
        else 
            inicio = data.current_page - n/2;
        
        fim = inicio + n-1;

        for (i=inicio;i<=fim;i++) {
            $("#paginationNav>ul").append(
                getItem(data,i)
            );
        }
        $("#paginationNav>ul").append(
            getNextItem(data)
        );
    }

    function getItem(data, i) {
        if (data.current_page == i) 
            s = '<li class="page-item active">';
        else
            s = '<li class="page-item">';
        s += '<a class="page-link" ' + 'pagina="'+i+'" ' + ' href="javascript:void(0);">' + i + '</a></li>';
        return s;
    }

    function getNextItem(data) {
        i = data.current_page+1;
        if (data.current_page == data.last_page) 
            s = '<li class="page-item disabled">';
        else
            s = '<li class="page-item">';
        s += '<a class="page-link" ' + 'pagina="'+i+'" ' + ' href="javascript:void(0);">Próximo</a></li>';
        return s;
    }
    
    function getPreviousItem(data) {
        i = data.current_page-1;
        if (data.current_page == 1) 
            s = '<li class="page-item disabled">';
        else
            s = '<li class="page-item">';
        s += '<a class="page-link" ' + 'pagina="'+i+'" ' + ' href="javascript:void(0);">Anterior</a></li>';
        return s;
    }
    
  </script>

</body>
</html>

