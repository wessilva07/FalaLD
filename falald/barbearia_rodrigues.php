<?php
// Inclua o arquivo de conexão
include 'conexao.php';

// Função para inserir um novo comentário no banco de dados
function inserirComentario($nome, $comentario, $avaliacao)
{
  global $conn;
  $nome = $conn->real_escape_string($nome);
  $comentario = $conn->real_escape_string($comentario);
  $avaliacao = intval($avaliacao); // Converte a avaliação para um valor inteiro

  // Verifica se a avaliação está entre 1 e 5 (número de estrelas permitido)
  if ($avaliacao < 1 || $avaliacao > 5) {
    return false; // Avaliação inválida, não insere no banco de dados
  }

  $sql = "INSERT INTO barbearia_rodrigues (nome, comentario, avaliacao) VALUES ('$nome', '$comentario', $avaliacao)";
  $result = $conn->query($sql);

  if ($result) {
    // Atualizar a média das avaliações
    $sqlUpdate = "UPDATE barbearia_rodrigues SET total_avaliacoes = total_avaliacoes + 1, avaliacao = (avaliacao + $avaliacao) / (total_avaliacoes + 1) WHERE id = LAST_INSERT_ID()";
    $conn->query($sqlUpdate);
  }

  return $result;
}

// Função para gerar as estrelas de acordo com a avaliação
function getStars($avaliacao)
{
  $fullStar = '<img src="imagens/estrela.png" class="estrela">';
  $emptyStar = '<img src="imagens/estrela-vazia.png" class="estrela">';

  $starsHTML = '';
  $avaliacao = floatval($avaliacao);

  for ($i = 1; $i <= 5; $i++) {
    if ($i <= $avaliacao) {
      $starsHTML .= $fullStar;
    } else {
      $starsHTML .= $emptyStar;
    }
  }

  return $starsHTML;
}


// Se um novo comentário foi enviado via POST, insira-o no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST["nome"];
  $comentario = $_POST["comentario"];

  // Verificar se a chave "avaliacao" existe no array $_POST
  if (isset($_POST["avaliacao"])) {
    $avaliacao = $_POST["avaliacao"];
  } else {
    // Caso a chave "avaliacao" não esteja definida, atribuir o valor padrão
    $avaliacao = 0;
  }

  if (!empty($nome) && !empty($comentario)) {
    inserirComentario($nome, $comentario, $avaliacao);

    // Habilitar o buffer de saída
    ob_start();

    // Redirecionar o usuário para a mesma página após o envio do formulário
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }
}

// Buscar todos os comentários do banco de dados
$sql = "SELECT nome, comentario, data_publicacao, avaliacao, total_avaliacoes FROM barbearia_rodrigues ORDER BY data_publicacao DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />

  <link rel="stylesheet" type="text/css" href="css/style.css" />

  <title>Barbearia Rodrigues</title>
</head>

<body>
  <header>
    <img src="imagens/fundo.png" alt="" />
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
      <div class="container">
        <button class="navbar-toggler bg-primary" data-toggle="collapse" data-target="#nav-principal">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-principal">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="index.html" class="nav-link" type="button">Home</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Bares</a>
              <ul>
                <li><a href="deck.php">Deck Café Bar</a></li>
                <li><a href="">Bar Do Maguinho</a></li>
                <li><a href="">Alternativa Bar</a></li>
                <li><a href="">Estação Bar e Restaurante</a></li>
                <li><a href="">Restaurante da coperativa</a></li>
                <li><a href="">Restaurante Tanaka</a></li>
                <li><a href="">Restaurante da Bet</a></li>
                <li><a href="">Restaurante Jaçanã</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Vestuário</a>
              <ul>
                <li><a href="">Marlete Modas</a></li>
                <li><a href="">Dona Cidinha</a></li>
                <li><a href="">Tiley Calçados</a></li>
                <li><a href="">Bell Calçados</a></li>
                <li><a href="">Jam Store</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Mercados</a>
              <ul>
                <li><a href="">Super Mercado Ramos</a></li>
                <li><a href="">Ibralândia</a></li>
                <li><a href="">Emporio Bom Sucesso</a></li>
                <li><a href="">Paula Paiva</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Academias</a>
              <ul>
                <li><a href="">Vila Fitnes</a></li>
                <li><a href="">Estação do Corpo</a></li>
                <li><a href="">Saúde e movimento</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Eletrodomésticos</a>
              <ul>
                <li><a href="">Decorart</a></li>
                <li><a href="">Loja do sergio</a></li>
                <li><a href="">Didico Moveis</a></li>
                <li><a href="">Santo Expedido</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Hoteis</a>
              <ul>
                <li><a href="">Hotel Nacional</a></li>
                <li><a href="">GabVini</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Farmacias</a>
              <ul>
                <li><a href="">Drogaria São José</a></li>
                <li><a href="">Farmácia Popular</a></li>
                <li><a href="">Med Farma</a></li>
                <li><a href="">Farmácia Popular</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Lanchonetes</a>
              <ul>
                <li><a href="">Alternativa Lanches</a></li>
                <li><a href="">Leiteria Central</a></li>
                <li><a href="">Padaria do Carlinho</a></li>
                <li><a href="">Padaria do Sr Domingos</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Barbearia</a>
              <ul>
                <li>
                  <a href="barbearia_rodrigues.php">Barbearia Rodrigues</a>
                </li>
                <li><a href="">Barbearia Andrade</a></li>
                <li><a href="">Barbearia na Regua</a></li>
                <li><a href="">Reis do Corte</a></li>
                <li><a href="">Barbearia do Gustavo</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Internet</a>
              <ul>
                <li><a href="">EServ</a></li>
                <li><a href="">Vero</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="login.html" class="nav-link" type="button">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-3" id="nav-principal">
          <h4>Outros comercios</h4>
          <ul>
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Tatuadores</a>
              <ul>
                <li><a href="">Zagnoli Tatoo</a></li>
                <li><a href="belotti_tatoo.php">Belotti Tatoo</a></li>
              </ul>
            </li>
            <br /><br />
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Auto-Escola</a>
              <ul>
                <li><a href="">Ouro Brancon</a></li>
                <li><a href="">Pit Stop</a></li>
              </ul>
            </li>
            <br /><br />
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Papelaria</a>
              <ul>
                <li><a href="">Patotinha</a></li>
                <li><a href="">Papelaria da Leia</a></li>
                <li><a href="">Papelaria do Marquinho</a></li>
              </ul>
            </li>
            <br /><br />
            <li class="nav-item">
              <a href="" class="nav-link" type="button">Loja de Ração</a>
              <ul>
                <li><a href="">Campo Pet Rural</a></li>
                <li><a href="">Fabricio</a></li>
                <li><a href="">Nutrilima</a></li>
              </ul>
            </li>
          </ul>
        </div>

        <div class="col-md-6">
          <h1><strong>Deck Café Bar</strong></h1>
          <img src="imagens/barbearia_fotos/logo_barbearia.jpeg" alt="" />
          <p class="mt-3">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
          </p>
          <br />
          <!-- Inicio Carousel -->
          <div class="container">
            <div class="row">
              <div class="col-md-8">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img class="d-block w-10" src="imagens/barbearia_fotos/apresentacao.jpeg" alt="Primeiro Slide" />
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="imagens/barbearia_fotos/equipamento.jpeg" alt="Segundo Slide" />
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-10" src="imagens/barbearia_fotos/corte.jpeg" alt="Terceiro Slide" />
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Próximo</span>
                  </a>
                </div>
              </div>
            </div>
          </div><!-- Fim Carousel -->
          <br />
          <!-- Inicio Localização -->
          <div class="container">
            <div class="row">
              <div class="col-md-8">
                <div>
                  <h1 class="display-5">Localização</h1>
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3703.4692780024398!2d-43.7922844!3d-21.839427399999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9f4b186a7a3ba5%3A0xf42241194a8cb890!2sDeck%20Caf%C3%A9%20e%20Bar!5e0!3m2!1spt-BR!2sbr!4v1683215775325!5m2!1spt-BR!2sbr" width="350" height="250" style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                  </iframe>
                </div>
              </div>
            </div>
          </div><!-- Fim Localização -->
          <br>
          <!-- ... Seu código HTML existente ... -->

          <div class="container">
            <div class="row">
              <div class="col-md-8">
                <div class="comment-box">
                  <h2>Comentários</h2>
                  <!-- Formulário para adicionar novos comentários -->
                  <form id="form-comentario" method="post">
                    <label for="nome">
                      <h4>Nome</h4>
                    </label><br>
                    <input type="text" id="nome" name="nome" required><br><br>

                    <label for="comentario">
                      <h4>Comentário</h4>
                    </label><br>
                    <textarea id="comentario" name="comentario" required></textarea>

                    <div class="avaliacao">
                      <label><img src="imagens/estrela-vazia.png" class="estrela-vazia" data-valor="1"></label>
                      <input type="radio" name="avaliacao" value="1" required>

                      <label><img src="imagens/estrela-vazia.png" class="estrela-vazia" data-valor="2"></label>
                      <input type="radio" name="avaliacao" value="2" required>

                      <label><img src="imagens/estrela-vazia.png" class="estrela-vazia" data-valor="3"></label>
                      <input type="radio" name="avaliacao" value="3" required>

                      <label><img src="imagens/estrela-vazia.png" class="estrela-vazia" data-valor="4"></label>
                      <input type="radio" name="avaliacao" value="4" required>

                      <label><img src="imagens/estrela-vazia.png" class="estrela-vazia" data-valor="5"></label>
                      <input type="radio" name="avaliacao" value="5" required>
                    </div>

                    <button class="btn btn-primary mt-2" type="submit">Enviar Avaliação</button>
                  </form>
                  <br>
                  <!-- Área para exibir os comentários -->
                  <!-- Seção de Comentários -->
                  <div id="comentarios">
                    <?php
                    // Buscar todos os comentários do banco de dados
                    $sql = "SELECT nome, comentario, data_publicacao, avaliacao, total_avaliacoes FROM barbearia_rodrigues ORDER BY data_publicacao DESC";
                    $result = $conn->query($sql);

                    // Inicializa as variáveis de contagem
                    $totalAvaliacoes = 0;
                    $somaAvaliacoes = 0;

                    // Inicializa uma variável para armazenar os comentários
                    $comentarios = array();

                    // Calcula a média das avaliações
                    if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $totalAvaliacoes += $row["total_avaliacoes"];
                        $somaAvaliacoes += $row["avaliacao"];
                        // Armazena os comentários em um array
                        $comentarios[] = $row;
                      }
                    }

                    ?>
                    <!-- Exibe a média das avaliações na parte de cima da página -->
                    <div class="media-avaliacoes">
                      Média das Avaliações: <?php echo ($totalAvaliacoes > 0) ? round($somaAvaliacoes / $totalAvaliacoes, 1) : 0; ?>
                      <img src="imagens/estrela.png">
                    </div>

                    <div class="avaliacao">
                      <div class="estrela">
                        <!-- Código das estrelas com os inputs de radio -->
                      </div>
                    </div>

                    <?php
                    // Exibir os comentários do banco de dados
                    if (!empty($comentarios)) {
                      foreach ($comentarios as $comentario) {
                        echo "<p><strong>" . $comentario["nome"] . ":</strong> " . $comentario["comentario"] . "</p>";
                        echo "<p>Avaliação: " . getStars($comentario["avaliacao"]) . "</p>";
                        echo "<hr>";
                      }
                    } else {
                      echo "<p>Nenhum comentário ainda. Seja o primeiro a comentar!</p>";
                    }
                    ?>

                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
  </section>

  <footer class="mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <p>
            <a href="index.html">Home</a>
            <a href="estudio.html">Estúdio</a>
            <a href="galeria.html">Galeria</a>
            <a href="orcamento.html">Orçamento</a>
          </p>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
          <a href="" class="btn btn-outline-success ml-2">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="" class="btn btn-outline-primary ml-2">
            <i class="fab fa-facebook-square"></i>
          </a>

          <a href="" class="btn btn-outline-dark ml-2">
            <i class="fab fa-instagram fa-lg"></i>
          </a>
        </div>
      </div>
    </div>
  </footer>
  <script>
    const estrelas = document.querySelectorAll(".estrela-vazia");

    // Função para preencher as estrelas ao passar o mouse
    function preencherEstrelas(valor) {
      estrelas.forEach((estrela, index) => {
        estrela.src = index < valor ? "imagens/estrela.png" : "imagens/estrela-vazia.png";
      });
    }

    // Função para atribuir o evento de clique nas estrelas
    function atribuirCliqueEstrelas() {
      estrelas.forEach((estrela) => {
        estrela.addEventListener("click", function() {
          const valorAvaliacao = this.getAttribute("data-valor");
          document.querySelector(`input[value="${valorAvaliacao}"]`).checked = true;
          preencherEstrelas(valorAvaliacao);
        });
      });
    }

    // Atribuir evento de hover nas estrelas vazias
    estrelas.forEach((estrela) => {
      estrela.addEventListener("mouseover", function() {
        const valorAvaliacao = this.getAttribute("data-valor");
        preencherEstrelas(valorAvaliacao);
      });

      estrela.addEventListener("mouseout", function() {
        const inputAvaliacao = document.querySelector('input[name="avaliacao"]:checked');
        if (inputAvaliacao) {
          preencherEstrelas(inputAvaliacao.value);
        } else {
          preencherEstrelas(0);
        }
      });
    });

    // Chamar a função para atribuir o evento de clique nas estrelas
    atribuirCliqueEstrelas();
  </script>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <div id="resultadoAvaliacao"></div>
</body>

</html>