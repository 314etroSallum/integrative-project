<?php
    include_once('SISTEMA/config.php');
?>

<?php
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

    $sql = "SELECT `product`.*, `image`.*, `product_rating`.*
            FROM `product`
            INNER JOIN `product_rating` 
                ON product.product_id = product_rating.product_id
            INNER JOIN `image` 
                ON product.image_id = image.image_id
            ORDER BY product_rating.rating DESC
            LIMIT 20";

    $result = $connection->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
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
</head>
<body>

    <header>
        <img src="images/logo.png" alt="Logo da Loja">
        <div class="search-bar">
            <input type="text" id="productSearch" placeholder="Buscar produtos...">
            <button onclick="searchProduct()">Buscar</button>
        </div>
    </header>

    <div class="container">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#vendidos">Mais Vendidos</a></li>
                <li><a href="#Novidades">Novidades</a></li>
                <li><a href="contact.php">Contato</a></li>
            </ul>
        </nav>

        <!-- Banner Principal -->
        <div class="banner">
            <h1>Ofertas Imperdíveis!</h1>
            <p>Compre agora e aproveite os melhores preços!</p>
        </div>

        <!-- Produtos Mais Vendidos -->
        <section class="section">
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
        <section class="section">
            <h2 class="section-title" id="Novidades">Produtos</h2>
            <div class="grid" id="productGrid">
                <?php foreach ($products as $product): ?>
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