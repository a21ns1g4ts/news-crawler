# Janela News 1.0

### Web service de notícias

# Requisitos do sistema

Para iniciar o processo de instalação são necessários
  
* Git
* Apache2 
* PHP ^7.3
* Composer ^1.6
* Supervisor ^3.0

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
    $ sudo apt-get install php7.3-mysql

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

     php artisan key:generate
    
Migrar e popular base de dados

     php artisan migrate:fresh --seed
     
     
Configurar o supervisor de trabalhos

        sudo apt install supervisor
        service supervisor status
        sudo groupadd supervisor    
        sudo usermod -a -G supervisor <seu usuário>

Configurar supervisor 

        sudo nano /etc/supervisor/supervisord.conf   
        
Compare 
         
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

Adicione um supervisor para aplicação:

        sudo nano /etc/supervisor/conf.d/queue.conf
        
        [program:queue]
        process_name=%(program_name)s_%(process_num)02d
        command=sudo php /<path_to_aplication>/artisan queue:work --timeout=600
        user=root
        autostart=true
        autorestart=true
        numprocs=1
        redirect_stderr=true
        stdout_logfile=/<path_to_aplication>/storage/logs/news-queue.log

Ative as configurações realizadas:
        
        sudo supervisorctl reread
        sudo supervisorctl update
        sudo supervisorctl status      
        
Configurar crontab no sistema operacional

     crontab -e 

Adicionar seguinte linha

    * * * * * cd /<path_path_to_aplication> && php artisan schedule:run >> /dev/null 2>&1
          
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

Acessar o endereço: http://news-janelaunica.local/sources/FIEPA

# Fim
