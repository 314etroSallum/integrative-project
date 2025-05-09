<?php
    include_once('SISTEMA/config.php');
?>

<?php
    $id = $_GET['product_id'];

    // consulta para pegar 4 produtos aleatórias
    $sql = "SELECT `product`.*, `image`.*
            FROM `product`
            JOIN `image`
                ON product.image_id = image.image_id and product.product_id = $id
            LIMIT 1";

    $result = $connection->query($sql);

    $product = $result->fetch_assoc();

    $sql = "SELECT `product`.*, `image`.*, `product_rating`.*
            FROM `product`
            INNER JOIN `product_rating` 
                ON product.product_id = product_rating.product_id
            INNER JOIN `image` 
                ON product.image_id = image.image_id
            ORDER BY product_rating.rating DESC
            LIMIT 4";

    $result = $connection->query($sql);

    $products_per_rating = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products_per_rating[] = $row;
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Online - Design Profissional</title>
    <style>
        /* Estilos Globais */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header com Logo e Barra de Busca */
        header {
            background-color: #000000;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            height: 50px;
        }

        .search-bar {
            width: 50%;
            display: flex;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        .search-bar button {
            background-color: #ff5722;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-left: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #e64a19;
        }

        /* Menu de Navegação */
        nav {
            background-color: #ffffff;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: space-around;
            padding: 0;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        nav ul li a:hover {
            color: #ff5722;
        }

        /* Banner de Destaque */
        .banner {
            background-color: #000000;
            padding: 50px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .banner h1 {
            font-size: 3rem;
            color: #333;
        }

        .banner p {
            font-size: 1.5rem;
            color: #555;
        }

        /* Categorias */
        .categories {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .category-card {
            background-color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin: 0 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .category-card img {
            max-width: 100%;
            border-radius: 8px;
        }

        .category-card h3 {
            margin-top: 15px;
            font-size: 1.5rem;
            color: #333;
        }

        /* Produtos em Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .card h3 {
            font-size: 1.4rem;
            margin-top: 10px;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ff5722;
            margin: 10px 0;
        }

        .discount {
            font-size: 1rem;
            color: #d32f2f;
        }

        .card button {
            background-color: #ff5722;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .card button:hover {
            background-color: #e64a19;
        }

        .rating {
            margin: 10px 0;
        }

        .star {
            color: #ffcc00;
            font-size: 1.2rem;
        }

        /* Filtros */
        .filters {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            background-color: #f0f0f0;
            margin-bottom: 20px;
        }

        .filters select, .filters input[type="search"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }



        .section-title {
        font-size: 2.5rem; /* Aumenta o tamanho da fonte */
        color: #ff5722; /* Cor de destaque */
        text-align: center; /* Centraliza o texto */
        margin-bottom: 30px; /* Espaçamento inferior */
        position: relative;
    }

    /* Barra decorativa abaixo do título */
    .section-title::after {
        content: '';
        width: 80px; /* Largura da barra */
        height: 4px; /* Altura da barra */
        background-color: #ff5722; /* Mesma cor do texto */
        position: absolute;
        bottom: -10px; /* Posiciona a barra abaixo do texto */
        left: 50%; /* Centraliza horizontalmente */
        transform: translateX(-50%); /* Ajusta a centralização */
    }

    </style>
      <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', 'Roboto', sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }
        h1 {
            margin-top: 20px;
            text-align: center;
            color: #333;
            font-size: 2rem;
        }
        .f {
            display: flex;
            flex-wrap: wrap; /* Permitir que os itens se movam para a próxima linha */
        }
        .a {
            align-items: center;
        }
        .j {
            justify-content: center;
        }
        .cn {
            height: 100vh;
            padding: 20px;
        }
        .wp {
            --t: 900px;
            width: var(--t);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .mgt {
            margin-top: 10px;
        }
        /* Zoom styles */
        .zoom, .original {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #target {
            width: calc(var(--t) / 2);
            transition: opacity 0.3s ease;
        }
        .zoom .viewer img {
            position: absolute;
        }
        .magnifier {
            display: none; /* Lupa removida */
        }
        .magnifier, .viewer {
            display: none;
        }
        .original:hover ~ div {
            display: block;
        }
        .original::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        /* Styles for the image gallery */
        .gallery {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 0;
        }
        .gallery img {
            width: 100px;
            cursor: pointer;
            transition: transform 0.3s ease, border 0.3s ease;
            border: 2px solid transparent;
            border-radius: 5px;
        }
        .gallery img:hover {
            transform: scale(1.1);
            border-color: #007bff;
        }
        .gallery img.active {
            border-color: #007bff;
            transform: scale(1.1);
        }
        /* Scrollbar styling */
        .gallery::-webkit-scrollbar {
            height: 6px;
        }
        .gallery::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 3px;
        }
        /* New styles for the availability text */
        .availability {
            margin-left: 10px; /* Diminuiu a margem */
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        .availability-container {
            display: flex;
            align-items: center;
            margin-left: 20px; /* Espaço entre a imagem e o texto */
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .wp {
                width: 100%; /* Ocupa 100% da largura da tela */
            }
            #target {
                width: 80%; /* Ajusta a largura da imagem principal */
            }
            .gallery {
                flex-direction: row; /* Mantém as imagens em uma linha */
                overflow-x: auto; /* Permite rolagem horizontal */
                padding: 10px 0; /* Adiciona um espaço em volta da galeria */
            }
            .gallery img {
                width: 70px; /* Diminui o tamanho das miniaturas */
            }
            h1 {
                font-size: 1.5rem; /* Ajusta o tamanho do título */
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.2rem; /* Ajusta ainda mais o tamanho do título */
            }
            .availability {
                font-size: 1.2rem; /* Ajusta o tamanho do texto de disponibilidade */
            }
        }

    .product-container {
        display: flex;
        flex-direction: row; /* Garante que fique lado a lado */
        align-items: center;
        gap: 40px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 30px;
        max-width: 1000px;
        width: 100%;
    }

    .product-image img {
        width: 320px;
        height: auto;
        border-radius: 8px;
        object-fit: contain;
    }

    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .product-info h1 {
        font-size: 32px;
        margin-bottom: 10px;
        color: #333;
    }

    .product-info .description {
        font-size: 18px;
        color: #666;
        margin-bottom: 20px;
    }

    .buttons {
        display: flex;
        gap: 15px;
    }

    .buttons button {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        background-color: red;
        color: white;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        transition: background-color 0.2s ease;
    }

    .buttons button:hover {
        background-color: #cc0000;
    }

        </style>
        
    </style>
</head>
<body>

    <header>
        <img src="images/logo.png" alt="Logo da Loja">
        <div class="search-bar">
            <input type="text" id="productSearch" placeholder="Buscar produtos...">
            <button onclick="searchProduct()">Buscar</button>
        </div>
    </header>
    <h1 style="visibility: hidden;" >Produto - E-commerce</h1>
    <div style="position: relative; top: -200px;" class="cn f a j">
            <aside style="display: flex; align-items: center;">
            <div class="wp">
            <div class="product-container">
            <div class="product-image">
            <img src="<?php echo htmlspecialchars($product['image_uri']); ?>" alt="Correia" />
            </div>
            <div class="product-info">
            <h1><?php
                                echo htmlspecialchars($product['product_name']);
                            ?></h1>
            <p class="description"><?php
                                echo htmlspecialchars($product['product_description']);
                            ?></p>
            <div class="buttons">
                <button class="buy">Comprar</button>
                <a href="/"><button class="home">Home</button></a>
            </div>
            </div>
        </div>
    </aside>
</div>
</div>
    <div class="container">
       

        <!-- Produtos Mais Vendidos -->
        <section class="section" style="position: relative; top: -380px;">
            <h2 id="vendidos">Produtos mais bem avaliados</h2>
            <div class="grid" id="productGrid">
                <?php foreach ($products_per_rating as $product): ?>
                    <div class="card" data-name="<?php
                                echo htmlspecialchars($product['product_name']);
                            ?>">
                        <img src="<?php
                                echo htmlspecialchars($product['image_uri']);
                            ?>" alt="<?php
                            echo htmlspecialchars($product['image_uri']);
                        ?>">
                        <h3><?php
                                echo htmlspecialchars($product['product_name']);
                            ?></h3>

                        <span>
                        <?php
                            echo htmlspecialchars($product['review']);
                        ?></span>
                        <div style="position: relative; top: -10px;" class="rating">
                            <?php for ($star = 0; $star < $product['rating']; $star++): ?>
                                <span class="star">&#9733;</span>
                            <?php endfor; ?>
                            <?php for ($star = $product['rating'] ; $star < 5; $star++): ?>
                                <span class="star">&#9734;</span>
                            <?php endfor; ?>
                            
                            (<?php
                                echo htmlspecialchars($product['rating']);
                            ?>)
                        </div>
                        <a href="product.php?product_id=
                                <?php 
                                    echo $product['product_id'];
                                ?>">
                            <button style="position: relative; top: -20px;">Confira</button>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
    
<footer  class="gray-background">
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

<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script type="text/javascript" src="js/zoom.js"></script>
<script type="text/javascript">
    // Initialize zoom
    var l = $('#target').zoom(2);

    // Change zoom level
    $('input[type="range"]').on('change', function () {
        l.setZoom(this.value);
    });

    // Gallery image click event
    $('.gallery img').on('click', function () {
        // Remove 'active' class from all thumbnails
        $('.gallery img').removeClass('active');
        
        // Add 'active' class to the clicked thumbnail
        $(this).addClass('active');
        
        var newSrc = $(this).attr('src');
        
        // Update the main image with a smooth transition
        $('#target').css('opacity', 0);
        setTimeout(function () {
            $('#target').attr('src', newSrc);
            $('.viewer img').attr('src', newSrc);
            $('#target').css('opacity', 1);
        }, 300);
        
        // Reset zoom when image is changed
        l.setZoom(2);
    });
</script>

    <script>
        function searchProduct() {
            const searchInput = document.getElementById('productSearch').value.toLowerCase();
            const products = document.querySelectorAll('.card');

            products.forEach(product => {
                const productName = product.getAttribute('data-name').toLowerCase();
                if (productName.includes(searchInput)) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });
        }
    </script>

</body>
</html>
