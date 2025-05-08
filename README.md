# 🚀 Projeto Integrador III

Site de e-commerce para venda de peças e produtos para veículos automotores

---

## 🧰 Tecnologias Utilizadas

- Docker 🐳
- PHP
- MySQL

---

## ⚙️ Pré-requisitos

Antes de rodar este projeto, certifique-se de ter instalado:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

---

## ▶️ Como rodar o projeto

Execute o comando abaixo na raiz do projeto onde se encontra o ```docker-compose.yml```:

```docker compose up -d```

## Configurando mysqli

Identifique o ID do container com o comando

```docker ps```

Entre no container com o comando

```docker exec -it {CONTAINER_ID OU CONTAINER_NAME} /bin/bash```

E faça a instalação do 'mysqli', do 'pdo' e do 'pdo_mysql' dentro do container

```docker-php-ext-install mysqli pdo pdo_mysql```

Habilite o mysqli e o pdo_mysql

```docker-php-ext-enable mysqli pdo_mysql```

Após isso, reinicie o container

```docker restart {CONTAINER_ID OU CONTAINER_NAME}```