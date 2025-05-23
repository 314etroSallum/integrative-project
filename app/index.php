<?php
    include_once('SISTEMA/config.php');
?>

<?php
    // consulta para pegar 3 imagens aleatórias
    $sql = "SELECT `image_uri` FROM `image` ORDER BY RAND() LIMIT 3";
    $result = $connection->query($sql);

    $images = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['image_uri'];
        }
    }

    // consulta para pegar 4 produtos aleatórias
    /*
    $sql = "SELECT `product`.*, `image`.* 
    FROM `product` 
    JOIN `image` 
        ON product.image_id = image.image_id 
    ORDER BY RAND() LIMIT 4";
    */

    $sql = "SELECT `product`.*, `image`.*, `product_rating`.*
            FROM `product`
            INNER JOIN `product_rating` 
                ON product.product_id = product_rating.product_id
            INNER JOIN `image` 
                ON product.image_id = image.image_id
            ORDER BY product_rating.rating DESC
        LIMIT 4";

    $result = $connection->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/globals.css">
    <link rel="manifest" href="manifest.json">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
</head>
<script src="js/app.js"></script>
<body>
    <div class="navbar">
        <div class="header-inner-content">
            <h1 class="logo">GERAL<span> PEÇAS</span></h1>
            <nav>
                <ul>
                    <li><a href="/" style="text-decoration: none; color: rgb(255, 255, 255);">Home</a></li>
                    <li><a href="list.php" style="text-decoration: none; color: rgb(255, 255, 255);">Produtos</a></li>
                    <li><a href="sobre.php" style="text-decoration: none; color: rgb(255, 255, 255);">Sobre</a></li>
                    <li><a href="contact.php" style="text-decoration: none; color: rgb(255, 255, 255);">Contato</a></li>
                    <li><a href="SISTEMA/home.php" style="text-decoration: none; color: rgb(255, 255, 255);">Cadastro</a></li>
 
                 </ul>
            </nav>
            <div class="nav-icon-container">
                <a href="https://api.whatsapp.com/send?phone=5513996131106"><img src="images/whatsapp.png" alt=""></a>
                <img src="images/menu.png" class="menu-button">
            </div>
        </div>
    </div>

<header>
    <br><br><br><br>
<div class="header-inner-content">
<div class="header-buttom-side">
    <div class="header-buttom-side-left">
        <h2>Ofertas incríveis</h2>
        <p>
            Potencialize o desempenho e a 
            segurança do seu veículo com 
            nossa ampla variedade de peças 
            automotivas de qualidade. 
            Encontre tudo o que precisa 
            para manter seu carro em perfeitas 
            condições na nossa loja, onde 
            qualidade e confiança se encontram.
        </p>
        <style>
            button {
              background-color: white;
              border: none;
              color: black;
              padding: 10px 20px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              margin: 4px 2px;
              cursor: pointer;
            }
          
            button a {
              color: white;
              text-decoration: none;
            }
          </style>
          
        <button><a href="list.php" style="color: white;"> Ver agora</a> &#8594;</button>

    </div>
    <div class="header-buttom-side-right">
        <img src="images/autoparts.png" alt="">
    </div>
</div>
</div>
</header>

<main>
    <div class="gray-background">
        <div class="page-inner-content">
        <div class="cols cols-3">
            <!---
                <img src="images/products/4.png" alt="">
                <img src="images/products/5.png" alt="">
                <img src="images/products/6.png" alt="">
            -->
            <?php foreach ($images as $image): ?>
                <img src="
                    <?php
                        echo htmlspecialchars($image);
                    ?>" alt="">
            <?php endforeach; ?>

        </div>
        </div>
    </div>
    <div>

        <div class="page-inner-content">
            <h3 class="section-title">Amostra</h3>
            <div class="subtitle-underline"></div>
            <div class="cols cols-4">
                <?php foreach ($products as $product): ?>
                    <div class="product">
                            <img src="
                            <?php
                                echo htmlspecialchars($product['image_uri']);
                            ?>" alt="
                            <?php
                                echo htmlspecialchars($product['image_description']);
                            ?>">
                            <p class="product-name">
                            <?php
                                echo htmlspecialchars($product['product_name']);
                            ?></p>
                            <span>
                            <?php
                                echo htmlspecialchars($product['review']);
                            ?></span>
                            
                            <p class="rate">
                            <?php 
                            for ($rate = 0; $rate < $product['rating']; $rate++):
                                echo "&#9733;";
                            endfor;
                            for ($rate = $product['rating'] ; $rate < 5; $rate++):
                                echo "&#9734;";
                            endfor;
                            ?></p>

                            <div style="font-size: 16px;">
                                <!-- Botão com estilos CSS -->
                                <a href="product.php?product_id=
                                <?php 
                                    echo $product['product_id'];
                                ?>" style="display: inline-block;
                                                    padding: 2px 5px;
                                                    background-color: #FF0000; /* Vermelho */
                                                    color: #FFFFFF; /* Texto branco */
                                                    font-family: Arial, sans-serif;
                                                    font-size: 16px;
                                                    text-align: center;
                                                    text-decoration: none;
                                                    border: none;
                                                    border-radius: 5px;
                                                    cursor: pointer;
                                                    transition: background-color 0.3s ease;"
                                onmouseover="this.style.backgroundColor='#CC0000'"
                                onmouseout="this.style.backgroundColor='#FF0000'">Confira</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="gray-background">
        <div class="header-inner-content">
            <div class="header-buttom-side exclusive-container">
                <div class="header-buttom-side-left">
                    <h2>Descubra a Excelência Automotiva: Peças de Qualidade.</h2>
                    <p>
                       Na nossa loja, cada peça é escolhida 
                       a dedo para garantir o melhor desempenho 
                       e durabilidade para o seu veículo. 
                       Encontre soluções confiáveis para 
                       todas as suas necessidades automotivas.
           
                    </p>
                    <a href="#" style="text-decoration: none;">

</a>
                </div>
                <div class="header-buttom-side-right">
                    <img src="images/exclusive.png" alt="">
                </div>
            </div>
            </div>
    </div>
<br><br>
    <div>
        <h1 style="text-align: center;">Motivos para Comprar na <span style="color: rgb(255, 0, 0);">GERAL</span> PEÇAS</h1>
        <div class="page-inner-contant">
            <div class="testimonials">
                <div class="testimonial">
                    <p>"</p>
                    <P> Peças de Qualidade
                </P>
                <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
              
                </div>

                <div class="testimonial">
                    <p>"</p>
                    <P> Versatilidade de linha de peças leve e pesada.
                </P>
                <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
               
                </div>

                <div class="testimonial">
                    <p>"</p>
                    <P> Preço justo.
                </P>
                <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
    
                </div>
            </div>
        </div>
    </div>
</main>



<footer  class="gray-background" >
    <div class="page-inner-content footer-content">
        <div class="download-options">
           <div>
            <img src="images/logo.png" alt="">
           </div>
        </div>
        <div class="logo-footer">
            <h1 class="logo">AUTO<span>PEÇAS</span></h1>
            <p>
                ATENDIMENTO WHATSAPP
Converse pelo WhatsApp com um de nossos especialistas.

De segunda a sexta-feira das 08h às 18h.
 
<div style="margin: 6px;"></div>
<div style="display: flex; align-items: center; justify-content: center;">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16" style="margin-right: 5px;">
        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
    </svg>
    <a href="https://api.whatsapp.com/send?phone=5513996131106" target="_blank" style="text-decoration: none; color: inherit;"><span>+55 13 99613-1106</span></a>
</div>

               </p>
        </div>

        <div class="links-footer">
            <h3>Links</h3>
            <ul>
                <li><a href="/" style="text-decoration: none; color: rgb(182, 179, 179);">Home</a></li>
                <li><a href="list.php" style="text-decoration: none; color: rgb(182, 179, 179);">Produtos</a></li>
                <li><a href="sobre.php" style="text-decoration: none; color: rgb(182, 179, 179);">Sobre</a></li>
                <li><a href="Cadastro011/cadastro.php" style="text-decoration: none; color: rgb(182, 179, 179);">Cadastro</a></li>
            </ul>
        </div>
    </div>
    <hr class="page-inner-content"/>
    <div class="page-inner-content copyright">
        <p>GeralPeças 2024 - GeralPeças - Todos Direitos Reservados</p>
    </div>
</footer>
<script>
    const navbar = document.querySelector(".navbar");
    const menuButton = document.querySelector(".menu-button");

    menuButton>addEventListener("click",() => {
        navbar.classList.toggle("show-menu")
    })
</script>
</body>
</html>