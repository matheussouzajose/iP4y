### Introdução:
Este projeto foi desenvolvido como parte do processo de candidatura para a vaga de desenvolvedor.
O objetivo do projeto, que é criar uma API Restfull para realizar operações CRUD (Criar, Ler, Atualizar, Deletar) 
em registros de usuários.

### Tecnologias Utilizadas:
- **Docker:** Docker foi selecionado para containerizar o aplicativo, o que permite um ambiente de desenvolvimento isolado.
- **Nginx:** Nginx foi selecionado como um proxy reverso para direcionar solicitações HTTP para o aplicativo Laravel.
- **Laravel:** Laravel foi selecionado para construir o aplicativo devido à sua facilidade de uso, recursos de segurança
e capacidade de construir rapidamente.
- **MySQL:** MySQL foi selecionado como o sistema de gerenciamento de banco de dados para armazenar as informações de usuário.

### Clean Architecture:
O projeto foi desenvolvido seguindo os princípios da Clean Architecture. Isso envolve a separação das camadas de aplicação em:
- **Entidades:** Entidades de negócios, como a entidade "Usuário" no contexto deste aplicativo.
- **Casos de Uso:** Implementação dos casos de uso, que representam as operações CRUD.
- **Ui/Controladores:** Os controladores foram criados para lidar com as solicitações HTTP e interagir com os casos de uso.
- **Infrastrucuture:** Utilizado na camada de Frameworks e Drivers, especialmente para lidar com a infraestrutura web e banco de dados.

### Estrutura do Projeto:
Importante: 
- **src**
  - **Application:** Casos de Uso
  - **Domain:** Entidades
  - **Infrastructure:** Persistência no banco de dados. 
  - **Ui:** Controllers


### Funcionalidades:
- **[GET] - [Listar todos usuários com paginação]** http://localhost:8000/api/v1/users?page=1&total_page=2 
- **[GET] - [Listar usuário pelo ID]** http://localhost:8000/api/v1/users/{id}
- **[POST] - [Criar usuário]** http://localhost:8000/api/v1/users 
- **[PUT] - [Atualizar usuário pelo ID]** http://localhost:8000/api/v1/users/{id} 
- **[DELETE] - [Excluir usuário pelo ID]** http://localhost:8000/api/v1/users/{id} 

Obs: Regras para criação/atualização segue o que foi mencionado no desafio.

### Testes:
- Testes automatizados para garantir a qualidade do código e o funcionamento adequado do aplicativo.

### Aprendizados:
- Implementação da Clean Architecture.

### Conclusão:
Em resumo, este projeto demonstra a minha capacidade de desenvolver e implementar uma aplicação robusta de CRUD 
de usuários utilizando tecnologias modernas e boas práticas de desenvolvimento. A escolha de Docker como plataforma
de contêinerização proporcionou um ambiente de desenvolvimento consistente, enquanto o uso do Laravel 
agilizou a criação de recursos sólidos e seguros.

Além disso, a implementação da Clean Architecture ajudou a manter uma clara separação de preocupações em todas 
as camadas do aplicativo, tornando-o altamente testável e adaptável para futuros aprimoramentos.

A integração do MySQL para armazenamento de dados e o Nginx como servidor web e proxy reverso para distribuição de 
tráfego aprimoraram o desempenho, a segurança e a confiabilidade da aplicação.

Este projeto é um reflexo do meu comprometimento em desenvolver soluções de alta qualidade e escaláveis, seguindo as melhores práticas.

### Como utilizar:
Para iniciar os serviços, clone o projeto e abra um terminal na raiz e execute o seguinte comando via Makefile:

### Com Makefile
- Para construir as imagens do Docker Compose:
```make
make build
```

- Para iniciar o Docker Compose:
```make
make up
```

- Para criar as tabelas:
```make
make setup-database
```

- Para parar o Docker Compose:
```make
make down
```

- O comando make tests é utilizado para executar os testes dentro do container
```make
make test
```

- Para visualizar outras opções de comandos
```make
make help
```

### Observação:
Este repositório é apenas a parte do backend, para realizar a integração com o aplicativo React Native, segue as instruções desse [repositório](https://github.com/matheussouzajose/iP4y-App):
