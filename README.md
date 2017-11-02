Homologação

[![Deployment status from DeployBot](https://felipefernandes.deploybot.com/badge/23779030042320/119320.svg)](http://deploybot.com)

---

# Instalação

## Pré-requisitos

* Linux-based S.O. (Mac ou Linux) *
* [Docker](https://docs.docker.com/engine/installation/)

Obs.: Não testei no Windows, mas é possível usando VirtualBox ou o próprio Docker Toolbox.


## Instalação

 * Execute o script `build.sh`, ele irá baixar e instanciar o container Wordpress, instalar o core do WP, tema e plugins necessários.
 * Teste se tudo funcionou certinho usando o endereço `http://localhost:9001`
 * Faça login no painel do Wordpress e importe o arquivo XML que está contido no diretório `/setup`

### Parando o container

Basta executar na linha de comando `docker-compose down`