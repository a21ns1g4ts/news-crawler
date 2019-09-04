# Janela Conecta 1.0

### Web service conector entre os sistemas Janela Única

# Requisitos do sistema
  Para iniciar o processo de instalação são necessários
* Ubunto 18.4 | Debian 9 
* Git*
* Composer ^1.6*

## Instalação

##### PS: Todos os comandos após o clone tem como base o diretório raiz desta aplicação.

Clonar repositório

    $ git clone https://<usuario>@bitbucket.org/devmaiati/janela_conecta

Entrar na pasta do projeto 

    $ cd janela_conecta

Instalar depedências do projeto

    $ composer install

Dar permissão 777 para o diretório `/storage`

    $ sudo chmod -R 777 storage    

Copiar arquivo .env.example para .env

    $ cp .env.example .env

Configurar as as seguintes variaveis no arquivo ` .env`

    APP_NAME="Janela news"
    APP_ENV=<local ou production>
    APP_KEY=<chave gerada automaticamente>
    APP_DEBUG=true
    APP_URL=<uri do janela news>
    APP_TIMEZONE=America/Belem
    APP_LOCALE=br
    APP_FALLBACK_LOCALE=pt

    #Configurar informações do banco de dados
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=<nome do banco>
    DB_USERNAME=<usuário>
    DB_PASSWORD=<senha>

    CACHE_DRIVER=file
    QUEUE_CONNECTION=sync

    #configurar ciclo de atividades do web-crawler|robo de notícias
    ROBOTS_TIME_TO_WAKE=8:00
    ROBOTS_TIME_TO_SLEEP=20:00
    #Valores possíveis em minutos 1|5|10|15|30|60
    ROBOTS_DELAY=10

    DISCOVERY_DRIVE=google
    DISCOVERY_LANG=pt

    # Gerar chaves em:  https://aylien.com/
    DISCOVERY_AYLIEN_APP_ID=d2d6f921
    DISCOVERY_AYLIEN_API_KEY=17285822cd24a79863b2ace92598d676
    DISCOVERY_AYLIEN_API_END_POINT=https://api.aylien.com/api/v1

    # Gerar chaves em: https://cloud.google.com/natural-language/
    GOOGLE_APPLICATION_CREDENTIALS=<{caminho absoluto até o projeto}/storage/janela-news-5c7e56d8977c.json>  

Gerar chaves do sistema

    $ php artisan key:generate

###  Usando o docker

Instale o docker e o docker-compose

    $ sudo apt-get update
    $ sudo apt-get install docker
    $ sudo apt-get install docker-compose
    
Após instalar os programas execute os seguintes comandos na pasta raiz do projeto.    

Faça o build da imagem do projeto:

    $ sudo docker-compose build

Levante o container:

    $ sudo docker-compose up
    
Para encerrar o serviço use:   

    $ sudo docker-compose down
    
Acesse o endereço: http://janela-news.local:9090/sources/FIEPA   

Acessar o arquivo de log para verificar se os robos estão em funcionando de acordo com as configurações do ciclo de atividade:

    $ tail -f /storage/logs/lumen-<ano-mes-dia>.log 

Se tudo estiver ok então você verá o seguinte log por exemplo:

    [2019-08-30 10:00:01] local.INFO: start robot: App\Robots\AgenciaParaNewsRobot function: copiar_noticias_recentes into source: <SOURCE>  
    [2019-08-30 10:00:02] local.INFO: end robot: App\Robots\AgenciaParaNewsRobot function: copiar_noticias_recentes into source: <SOURCE>      
    
# Fim
