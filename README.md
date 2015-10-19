User api
============================

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources


INSTALLATION
------------
1. Clone Git repository https://github.com/fedman/user_api.git
    After cloning make sure that user_api/runtime and user_api/web/assets 
    directories are available for writing.
2. Open console and change directory to base directory of cloned project.
3. In the base directory of project run 'php composer update' command. It will
    download project's dependencies. Notice, that composer should be installed.
3. Create db and configure access in user_api/config/db.php
4. In the base directory run 'php yii migrate' to create tables in db.
5. Set virtual host. Example for apache(mod_rewrite module should be enabled):
    <VirtualHost *:80>
        ServerName frontend.dev
        ServerAlias 127.0.0.1
        DocumentRoot /path/to/yii-application/frontend/web/

        <Directory "/path/to/yii-application/frontend/web/">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php

            # ...other settings...
        </Directory>
    </VirtualHost>
6. Now you can use api.

API methods.
------------

1. Get all friendships
   @api {get} /friendships

2. Create friend
    @api {post} /friendships
    @apiParam {Integer} uid1 Oprional value 
    @apiParam {Integer} uid2 Oprional value 

3. Get friends of user. :id is ID of the user.
    @api {get} /friendships/show-friends/:id 

4. Delete friendship
    @api {delete} /friendships
    @apiParam {Integer} uid1 Oprional value 
    @apiParam {Integer} uid2 Oprional value