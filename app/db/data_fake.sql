INSERT INTO `user` (user_name, user_email, user_password, telphone, state, city, address, complement, is_admin, created_at, updated_at) VALUES
('Alice Santos', 'alice@example.com', 'hashedpass1', '11999999999', 'SP', 'São Paulo', 'Rua das Flores, 123', 'Apto 11', false, NOW(), NOW()),
('Bruno Lima', 'bruno@example.com', 'hashedpass2', '21988888888', 'RJ', 'Rio de Janeiro', 'Av. Brasil, 456', '', false, NOW(), NOW()),
('Carla Mendes', 'carla@example.com', 'hashedpass3', '31977777777', 'MG', 'Belo Horizonte', 'Rua Ouro Preto, 789', 'Bloco B', false, NOW(), NOW()),
('Daniel Souza', 'daniel@example.com', 'hashedpass4', '51966666666', 'RS', 'Porto Alegre', 'Rua dos Andradas, 321', '', true, NOW(), NOW()),
('Elisa Nunes', 'elisa@example.com', 'hashedpass5', '41955555555', 'PR', 'Curitiba', 'Rua XV de Novembro, 111', 'Casa 2', false, NOW(), NOW());


INSERT INTO `image` (image_name, image_description, image_uri, created_at, updated_at) VALUES
('Correia', 'Imagem de uma Correia', '/images/products/1.png', NOW(), NOW()),
('Lampada', 'Imagem de uma Lampada', '/images/products/2.png', NOW(), NOW()),
('Disco de Freio', 'Imagem de um Disco de Freio', '/images/products/3.png', NOW(), NOW()),
('Bateria Moura', 'Imagem de uma Bateria da Moura', '/images/products/4.png', NOW(), NOW()),
('Oléo de Motor 20w50 da Radnaq', 'Imagem de um Oléo de Motor 20w50 da Radnaq', '/images/products/5.png', NOW(), NOW());

INSERT INTO `product` (image_id, product_name, product_description, product_price, created_at, updated_at) VALUES
(1, 'Correia', 'Correia para seu automóvel', 199.90, NOW(), NOW()),
(2, 'Lampada Automotivo', 'Lampada automotivo de excelente qualidade', 1499.00, NOW(), NOW()),
(3, 'Disco de Freio', 'Disco de Freio Cromado', 5499.99, NOW(), NOW()),
(4, 'Bateria Moura', 'Bateria Moura de 100A - 24V', 2899.50, NOW(), NOW()),
(5, 'Oléo de Motor 20w50 da Radnaq', 'Oléo de Motor 20w50 da Radnaq', 299.00, NOW(), NOW());

INSERT INTO `product_rating` (user_id, product_id, rating, review, created_at, updated_at) VALUES
(1, 1, 5, 'Ótima Correia, super confortável!', NOW(), NOW()),
(2, 2, 4, 'Boa Lampada, mas poderia ser mais rápido.', NOW(), NOW()),
(3, 3, 5, 'Excelente desempenho, roda tudo!', NOW(), NOW()),
(4, 4, 3, 'Boa qualidade, mas um pouco cara.', NOW(), NOW()),
(5, 5, 4, 'Oléo de qualidade, recomendo.', NOW(), NOW());

INSERT INTO `shopping_cart` (created_at, updated_at) VALUES
(NOW(), NOW()),
(NOW(), NOW());

INSERT INTO `product_shopping_cart` (shopping_cart_id, product_id, created_at, updated_at) VALUES
(1, 1, NOW(), NOW()),
(1, 2, NOW(), NOW()),
(2, 3, NOW(), NOW()),
(2, 5, NOW(), NOW());

INSERT INTO `purchased` (shopping_cart_id, purchase_price, created_at, updated_at) VALUES
(1, 1698.90, NOW(), NOW()),
(2, 5798.99, NOW(), NOW());
