//Cadastro de novos usuários:
$("#cadastrar").on("click", () =>
  $.ajax({
    type: "GET",
    url: "components/formCadastro.html",
    //data: 'teste&teste2', //Parametro submetido para formCadastro.php
    dataType: "html",
    success: (dados) => {
      $("#target").html(dados);
      $("form button").on("click", (e) => {
        e.preventDefault();
        if (e.target.innerHTML == "Salvar") {
          let dados = $("form").serialize();
          //console.log(dados)
          $.ajax({
            type: "get",
            url: "connection/salvarUsuario.php",

            //contentType: 'aplication/w-xxx-form-urlencoded',
            data: dados,
            //dataType: "json",
            success: (d) => {
              console.log(d);
              $("#resultado_salvar").html(
                '<h4 class="text-success">Salvo com sucesso</h4>'
              );
            },
            error: (e) => {
              $("#resultado_salvar").html(
                '<h4 class="text-danger">Erro ao salvar</h4>'
              );
              console.log(e);
            },
          });
        } else {
          $("body").load("index.php");
        }
      });
    },
    error: (dados) => console.log("Erro: " + dados),
  })
);

//Operações de alteração de atributos nas tabelas
{
  //Resetar senha para 1234 
  $('td i').on('click', function (e) {
    //console.log('modal')
    //$(e.target).parent().siblings()[0].innerHTML.trim()
    let res
    let id
    let coluna
    let value
    let nome = $(e.target).parent().siblings()[4].innerHTML.trim()
    let msg = `<span>A ação a seguir irá trocar a senha para 1234 do usuário:<strong> ${nome}</strong>. Após o login será necessário trocar a senha</span>`

    $('#confirmacaoResetar').modal('show')
    $('div.modal-body').html(msg)

    id = $(e.target).parent().siblings()[0].innerHTML.trim();
    coluna = 'senha';
    value = '1234';
    res = {
      id: id,
      coluna: coluna,
      data: value,
    };

    res = JSON.stringify(res);
    $('#resetarSenha').on('click', () => {
      $.ajax({
        type: "post",
        url: "connection/updateUsuario.php",
        contentType: 'application/json',
        //dataType: 'JSON',
        data: res,
        success: (d) => {
          console.log('senha alterada com suceso')

        },
        error: function (d) {
          console.log(d)
        }
      })
      $('#confirmacaoResetar').modal('hide')
    })
  })

  function traduzirColuna(coluna) {
    switch (coluna) {
      case "Código do funcionário Fcerta":
        coluna = "cdfun"
        break
      case "Loja":
        coluna = "cdcon"
        break
      case "Nível":
        coluna = "nivel"
        break;
      case "Ativo":
        coluna = ""
        break;
      case "Nome Completo":
        coluna = "nome"
        break;
      case "Login Fcerta":
        coluna = "usuario"
        break;
      case "Resetar Senha":
        coluna = 'senha'
        break;
      default:
        coluna = ""
        break;
    }
    return coluna
  }

  function validaDados(coluna, dado) {
    let colunaTipo;
    //Evitando instanciar tipos primitivos a fim de melhorar qualidade de dados
    //Definindo tipo:
    dado = Number(dado);
    if (isNaN(dado)) {
      dado = "string";
    }
    switch (coluna) {
      case "Código do funcionário Fcerta":
        colunaTipo = 1;
      case "Loja":
        colunaTipo = 1;
      case "Nível":
        colunaTipo = 1;
        break;
      case "Ativo":
        if (dado == 1 || dado == 0) dado = true;
        colunaTipo = true;
        break;
      case "Nome Completo":
        colunaTipo = "string";
      case "Login Fcerta":
        colunaTipo = "string";
      case 'Resetar senha':
        colunaTipo = "string";
        break;
      default:
        console.log("Coluna inválida");
        break;
    }

    if (typeof colunaTipo == typeof dado) {
      return true;
    } else {
      return false;
    }
  }

  let coluna;
  let id;
  let valueInicial;
  let value;
  let target;
  $("tbody").on("dblclick", "td,input", (e) => {
    target = e.target
    id = $(e.target).siblings()[0].innerHTML.trim();
    valueInicial = e.target.innerHTML.trim();

    $(e.target).html(
      `<input class="col" type="text" placeholder="${valueInicial}">`
    );
    $("input").focus();
    //console.log(e.target.cellIndex)
    $("thead th").each(function (index, element) {
      if (e.target.cellIndex == index) {

        coluna = element.innerHTML.trim();
      }
    });

  });

  $(document).on("click", function () {
    value = value ? value : valueInicial;
    $(target).html(valueInicial);
    $("#resUpdate div").fadeOut(500);
    target = "";
  });

  $("tbody td").on('keyup',(e) => {
    if (e.keyCode == "27") {
      $(e.target).parent().html(valueInicial);
    }
    if (e.keyCode == "13") {
      //13=enter
      value = e.target.value;
      console.log(value)
      if (!validaDados(coluna, value)) {
        alert("Tipo de dado inserido não confere com o da tabela");
        value = valueInicial;
        $(e.target).parent().html(value);
        return;
      }
      let html
      coluna = traduzirColuna(coluna);

      if (coluna != '') {
        html = `<div class="container-fluid bg-secondary py-1">
        Coluna afetada -> ${coluna};
        Valor anterior -> ${valueInicial} alterado para ${value} 
        </div>`;
      } else {
        html = `<div class="bg-secondary py-1 text-danger">
          Erro
        </div>`
      }
      valueInicial = value
      $(html).hide().appendTo("#resUpdate").fadeIn(500);

      //valueInicial = value
      $(e.target).parent().html(value);

      let res = {
        id: id,
        coluna: coluna,
        data: value,
      };

      res = JSON.stringify(res);
      $.ajax({
        type: "post",
        url: "connection/updateUsuario.php",
        contentType: "application/json",
        data: res,
        dataType: "JSON",
        success: function (data) {
          console.log("sucesso")
          console.log(data);
        },
        error: function (data) {
          console.log(data);
        },
      });
    }
    //Req a ser enviada para o backend->
  });
}
$("#barraProgresso").toggle("medio");

//Algoritmo de pesquisa:
{

  const elementosTr = document.querySelectorAll('tbody tr')

  function padrao() {
    elementosTr.forEach(e => {
      document.querySelector('tbody').appendChild(e)
    })
  }

  function tratarDados(dado) {
    let dadoTratado = []

    dado.forEach(d => {
      let id = d[0]
      d.shift()
      dadoTratado[id] = d
    })

    return dadoTratado
  }

  function pesquisa(pesquisaStr) {
    let dadosTratados
    let pesquisa = pesquisaStr.replace('/', '')

    //Selecionar elemento cujo
    if (pesquisaStr !== '' && pesquisaStr !== '/') {
      document.querySelector('tbody').innerHTML = ''
      getDadosTabela().then(dadosTabela => {
        dadosTratados = tratarDados(dadosTabela)
        dadosTratados.forEach((elemento, id) => {
          //console.log(elemento+' Index: '+id)
          if (elemento[2].toLowerCase().match(pesquisa.toLowerCase()) || elemento[3].toLowerCase().match(pesquisa.toLowerCase())) {
            document.querySelector('tbody').innerHTML +=
              `
                      <tr id=${id}>
                          <td hidden>${id}</td>
                          <td class="col">${elemento[0]}</td>
                          <td class="col">${elemento[1]}</td>
                          <td class="col">${elemento[2]}</td>
                          <td class="col">${elemento[3]}</td>
                          <td class="col">${elemento[5]}</td>
                          <td class="col">${elemento[7]}</td>
                          <td class="col">
                              <i class=" btn btn-sm btn-warning fas fa-key" data-toggle="modal" data-target="#confirmacaoResetar">
                          </td>
                      </tr>
                      `
          }

        })
      })

    }
  }


  document.addEventListener('keypress', (evento) => {
    if (evento.keyCode == 47) {
      document.getElementById('pesquisa').value = ''
      document.getElementById('pesquisa').focus()
    }

  })

  document.getElementById('pesquisa').addEventListener('keypress', (evento) => {
    pesquisa(evento.target.value)
  })

  document.getElementById('pesquisa').addEventListener('keyup', (evento) => {
    pesquisa(evento.target.value)
    if (evento.target.value == '') padrao()
  })
}
