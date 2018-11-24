# exemplo-zend-doctrine
projeto com zend e doctrine

Referências:
https://github.com/roggeo/using-doctrineorm-zf3
https://samsonasik.wordpress.com/2013/04/10/zend-framework-2-generate-doctrine-entities-from-existing-database-using-doctrinemodule-and-doctrineormmodule/


1 - No terminal executar para evitar timeout composer:
networksetup -setv6off Wi-Fi


2 - Obter o zendframework:
composer create-project -sdev zendframework/skeleton-application path/to/install

3 - Executar o comando para atualizar os pacotes:
composer update

4 - Obter o doctrine:
    a - o doctrine-module:
    composer require doctrine/doctrine-module
    b - o doctrine-orm-module
    composer require doctrine/doctrine-orm-module
5 - Observe que após instalações o config/modules.config.php deve estar como o presente neste projeto.

6 - criar o arquivo doctrine.local.php em config/autoload e inserir o conetúdo presente no arquivo deste projeto, ajustando os dados de conexão.


7 - criar a seguinte estrutura:
/module
    /Album
        /config
        /src
            /Controller
            /Form
            /Model
        /view
            /album
                /album

8 - criar o arquivo /module/Album/src/Module.php para definir qual configuração será aplicada


9 - no composer.json
adicionar:

"autoload": {
    "psr-4": {
        "Album\\": "module/Album/src/"
    }
},

10 - No terminal executar para aplicar as configurações do composer.json:
composer dump-autoload

11 - no config/modules.config.php principal adicionar o module "Album", conforme arquivo presente neste projeto.


12 - criar o arquivo module/Album/src/Controller/AlbumController.php
    - cada function terminada em Action, equivale a url sem o action ex.:
    o addAction equivale a url add/
URL                             Metodo
http://.../album            =>	Album\Controller\AlbumController::indexAction
http://.../album/add        =>	Album\Controller\AlbumController::addAction
http://.../album/edit       =>	Album\Controller\AlbumController::editAction
http://.../album/delete     =>	Album\Controller\AlbumController::deleteAction

13 - criar arquivos:

module/Album/view/album/album/add.phtml
module/Album/view/album/album/delete.phtml
module/Album/view/album/album/edit.phtml
module/Album/view/album/album/index.phtml


14 - execute o sql dentro de data/base.sql * observando o nome da base configurada em config/autoload/doctrine.local.php


15 - Configuração do module/Album/config/module.config.php antes de executar os comandos na parte de driver do doctrine:
__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'



16 - no terminal vá para pasta raiz do projeto onde aparece:
config/
data/
module/
public/
vendor/
...
execute:

./vendor/doctrine/doctrine-module/bin/doctrine-module orm:convert-mapping --namespace="Album\\Entity\\" --force  --from-database annotation ./module/Album/src/

esse comando irá gerar na pasta module/Album/src/Album/Entity/
dois arquivos sem geters e seters:
Album.php
Track.php


por fim executar o comando:
./vendor/doctrine/doctrine-module/bin/doctrine-module orm:generate-entities ./module/Album/src/ --generate-annotations=true

irá gerar o geters e seteres para o arquivo Album.php e Track.php

17 - Procurar em module/Album/src/Album/Entity/* "Album\" e substituir por "Album\Album\"

18 - Configuração do module/Album/config/module.config.php após de executar os comandos na parte de driver do doctrine:
__NAMESPACE__ .'\\'.__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'

19 - realizar o teste, executar a url:
http://.../public/album/

