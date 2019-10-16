# Janela News 1.0

### Web service de notícias

# Requisitos do sistema
  Para iniciar o processo de instalação são necessários
* Ubunto 18.4 | Debian 9 
* Git
* Apache2 
* PHP ^7.3
* Composer ^1.6

### Extensões do PHP

* php-mbstring
* php-xml
* php-bcmath
* php-dom
* php-pgsql || php-mysql
* php-curl

Instalar os módulo do php.

    $ sudo apt-get install php7.3-mbstring 
    $ sudo apt-get install php7.3-xml 
    $ sudo apt-get install php7.3-bcmath
    $ sudo apt-get install php7.3-dom 
    $ sudo apt-get install php7.3-curl
    $ sudo apt-get install php7.3-pgsql || $ sudo apt-get install php7.3-mysql

## Instalação

Clonar repositório

    $ git clone https://<usuario>@bitbucket.org/devmaiati/janela_news

Entrar na pasta do projeto 

    $ cd janela_news

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

Configurar crontab no sistema operacional

    $ crontab -e 

Adicionar seguinte linha

    * * * * * php /<localização do diretório do projeto>/janela_news/artisan schedule:run >> /dev/null$

Salvar e acessar o arquivo de log para verificar se os robos estão em funcionando de acordo com as configurações do ciclo de atividade:

    $ tail -f /storage/logs/lumen-<ano-mes-dia>.log 
    
Configurar o supervisor de trabalhos

        sudo apt install supervisor
        service supervisor status
        sudo groupadd supervisor    
        sudo usermod -a -G supervisor <seu usuário>
        sudo nano /etc/supervisor/supervisord.conf
        
Adicione o conteúdo: 
         
         ; supervisor config file
         
         [unix_http_server]
         file=/var/run/supervisor.sock   ; (the path to the socket file)
         chmod=0770                       ; sockef file mode (default 0700)
         chown=root:supervisor
         
         [supervisord]
         logfile=/var/log/supervisor/supervisord.log ; (main log file;default $CWD/supervisord.log)
         pidfile=/var/run/supervisord.pid ; (supervisord pidfile;default supervisord.pid)
         childlogdir=/var/log/supervisor            ; ('AUTO' child log dir, default $TEMP)
         
         ; the below section must remain in the config file for RPC
         ; (supervisorctl/web interface) to work, additional interfaces may be
         ; added by defining them in separate rpcinterface: sections
         [rpcinterface:supervisor]
         supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface
         
         [supervisorctl]
         serverurl=unix:///var/run/supervisor.sock ; use a unix:// URL  for a unix socket
         
         ; The [include] section can just contain the "files" setting.  This
         ; setting can list multiple files (separated by whitespace or
         ; newlines).  It can also contain wildcards.  The filenames are
         ; interpreted as relative to this file.  Included files *cannot*
         ; include files themselves.
         
         [include]
         files = /etc/supervisor/conf.d/*.conf
         
 Reinicie o serviço:  
         
         sudo service supervisor restart                 

Adicione o supervisor para aplicação:

        sudo nano /etc/supervisor/conf.d/janela-news.conf
        
        [program:janela-news-queue]
        process_name=%(program_name)s_%(process_num)02d
        command=sudo php /<path_to_aplication>/artisan queue:work --tries=3 --daemon --queue=test -vvv
        user=root
        autostart=true
        autorestart=true
        numprocs=1
        redirect_stderr=true
        stdout_logfile=/<path_to_aplication>/storage/logs/test.log

Finalizando:
        
        supervisorctl reread
        supervisorctl update
        supervisorctl status      
          
Se tudo estiver ok então você verá o seguinte log por exemplo:

    [2019-08-30 10:00:01] local.INFO: start robot: App\Robots\AgenciaParaNewsRobot function: copiar_noticias_recentes into source: <SOURCE>  
    [2019-08-30 10:00:02] local.INFO: end robot: App\Robots\AgenciaParaNewsRobot function: copiar_noticias_recentes into source: <SOURCE>      

###   Configurar virtual host

Configurar virtual host apontando para o diretório `/janela_news/public/`

* criar o arquivo `janela_news.conf`

      $ sudo nano /etc/apache2/sites-available/janela_news.conf

* Copiar o conteúdo abaixo para o arquivo `janela_news.conf`      
    ```
    <VirtualHost *:80>
        ServerName news-janelaunica.local
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/janela_news/public/
        
        ErrorLog ${APACHE_LOG_DIR}/janela_news_error.log
        CustomLog ${APACHE_LOG_DIR}/janela_news_access.log combined
    
        <Directory /var/www/janela_news/public/>
             Options Indexes FollowSymLinks MultiViews
             AllowOverride all
             Require all granted
        </Directory>
    </VirtualHost>
    ```
Acrescentar host ao arquivo `/etc/hosts`
          
     $ sudo nano /etc/hosts
```
127.0.1.1  news-janelaunica.local
```

Acessar o endereço: http://news-janelaunica.local/sources/FIEPAZ

# Fim
