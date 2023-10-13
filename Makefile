DOCKER_COMPOSE := docker compose
DOCKER_EXEC := ${DOCKER_COMPOSE} exec app

.DEFAULT_GOAL := help

help:
	@echo "Uso: make [alvo]"
	@echo ""
	@echo "Alvos disponíveis:"
	@echo "  up             Inicia todos os contêineres definidos no Docker Compose"
	@echo "  build          Inicia o Build de todos os contêineres definidos no Docker Compose"
	@echo "  down           Para todos os contêineres"
	@echo "  restart        Reinicia todos os contêineres"
	@echo "  logs           Exibe logs dos contêineres"
	@echo "  exec           Executa um comando em um serviço específico (exemplo: make exec service=comando)"
	@echo "  ps             Lista os contêineres em execução"
	@echo "  setup-database Realiza a migração das tabelas"
	@echo "  test           Roda todos os testes"
	@echo "  help           Exibe esta mensagem de ajuda"

build:
	${DOCKER_COMPOSE} build;

up:
	${DOCKER_COMPOSE} up -d;

down:
	${DOCKER_COMPOSE} down;

restart:
	${DOCKER_COMPOSE} restart;

logs:
	${DOCKER_COMPOSE} logs -f;

ps:
	${DOCKER_COMPOSE} ps;

setup-database:
	@echo "Criando as tabelas no banco de dados..."
	$(DOCKER_EXEC) php artisan migrate:refresh

test:
	@echo "Criando as tabelas no banco de dados..."
	$(DOCKER_EXEC) php artisan test

.PHONY: help build up down restart logs ps setup test
