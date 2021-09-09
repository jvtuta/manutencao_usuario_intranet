<?php
require_once 'middlewares/Autenticacao.php';
require_once 'connection/dbConfig.php';
$db = Db::getDb();
$usuarios = Usuario::all($db);
$urlpath = $_SERVER['REQUEST_URI'];
Autenticacao::handle($urlpath);
if ($_SESSION['autenticado']) {
?>

    <!DOCTYPE html>
    <html lang="pt">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Farmacotécnica - Manutenção de usuários</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="shortcut icon" href="https://ticket.memoriaram.com.br/pics/favicon.ico">
        <link rel="stylesheet" href="assets/estilo.css">
        <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
        <!-- <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script> -->
        <!-- <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script> -->

        <script>
           async function getDadosTabela() {
                const dadosTabela = await JSON.parse('<?php echo json_encode($usuarios); ?>');
                return dadosTabela
            }
        </script>
        <script src="scripts/jquery.min.js"></script>
        <!-- <script src="scripts/vue.js"></script> -->

    </head>

    <body>
        <header class="container-fluid bg-dark mb-3 p-1">
            <a href="http://memoriaram.com.br/" target="_blank">
                <img src="assets/logo.png" alt="" width="220px" class="float-start ms-3">
            </a>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1 class="text-white ms-3 ">
                            <a href="index.php" style="color: white; text-decoration: none;">Manutenção de Usuários</a>
                        </h1>
                    </div>
                    <div class="col mb-3 mt-3">
                        <ul class="nav float-end">
                            <li class=" nav-item">
                                <button class="btn btn-outline-secondary" type="button" id="cadastrar">Cadastrar</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div class="container-fluid p-0" id="resUpdate"></div>
            


        <div class="container" id="app">
            <div class="row">
                <div class="col" id="target">
                    <div class="col-4">
                        <div class="input-group input-group-sm">
                            <label for="pesquisa" class="input-group-text">Pesquisar</label>
                            <input type="search" id="pesquisa" class="form-control" v-model="pesquisa" placeholder='Pressione "/" para Pesquisar pelo nome ou usuário'>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th hidden>

                                </th>
                                <th class="col">
                                    Loja
                                </th>
                                <th class="col">
                                    Código do funcionário Fcerta
                                </th>
                                <th class="col">
                                    Nome Completo
                                </th>
                                <th class="col">
                                    Login Fcerta
                                </th>
                                <th class="col">
                                    Nível
                                </th>
                                <th class="col">
                                    Ativo
                                </th>
                                <th class="col">
                                    Resetar senha
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            //$usuarios = [[1, 1234, 1234, 'TesteNome1', 'teste.login1', 'testeAtivo1', 'testeNivel1', '1', '1'], [2, 12345, 12345, 'TesteNome2', 'teste.login2', 'TesteAtivo2', 'TesteNivel2', '1', '1'], ['teste', 'teste2', 'teste3', 'teste3', 'tete5', 'teste6', 'teste7', 'teste8', '1']];
                            foreach ($usuarios as $usuario) { ?>
                            
                                <tr id="<?php echo $usuario['0'] ?>">
                                    <td hidden>
                                        <?php echo $usuario['0']
                                        ?>
                                    </td>
                                    <td class="col">
                                        <?php echo $usuario['1'] //Loja cadastrada 
                                        ?>
                                    </td>

                                    <td class="col">
                                        <?php echo $usuario['2'] //Código do funcionario 
                                        ?>
                                    </td>

                                    <td class="col">
                                        <?php echo $usuario['3'] //Nome do funcionário
                                        ?>
                                    </td>

                                    <td class="col">
                                        <?php echo $usuario['4'] //Login Fcerta 
                                        ?>
                                    </td>

                                    <td class="col">
                                        <?php echo $usuario['6'] //Nivel
                                        ?>
                                    </td>

                                    <td class="col">
                                        <?php echo $usuario['8'] //Ativo 
                                        ?>
                                    </td>
                                    <td class="col ">
                                        <i class=" btn btn-sm btn-warning fas fa-key" data-toggle="modal" data-target="#confirmacaoResetar">
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmacaoResetar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Resetar senha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="resetarSenha">Continuar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


        <script src="scripts/script.js"></script>
        <script id="script"></script>
    <?php

} else {
    echo 'Necessário privilégios adminsitrativos';
}
    ?>
    </body>

    </html>