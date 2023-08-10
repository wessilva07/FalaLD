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