oauth2-server-php\src\OAuth2\Storage\Pdo.php

Denne filen er extenda slik at database tilpasser brukere.
Alle modifikasjonene finnes i filen ukmlib/OAuth/Pdo.php



 ```php
 public function getBuildSql($dbName = 'oauth2_server_php')
    {
        $sql = "
        CREATE TABLE {$this->config['client_table']} (
          client_id             VARCHAR(80)   NOT NULL,
          client_secret         VARCHAR(80),
          redirect_uri          VARCHAR(2000),
          grant_types           VARCHAR(80),
          scope                 VARCHAR(4000),
          user_id               VARCHAR(80),
          PRIMARY KEY (client_id)
        );

            CREATE TABLE {$this->config['access_token_table']} (
              access_token         VARCHAR(40)    NOT NULL,
              client_id            VARCHAR(80)    NOT NULL,
              user_id              VARCHAR(80),
              expires              TIMESTAMP      NOT NULL,
              scope                VARCHAR(4000),
              PRIMARY KEY (access_token)
            );

            CREATE TABLE {$this->config['code_table']} (
              authorization_code  VARCHAR(40)    NOT NULL,
              client_id           VARCHAR(80)    NOT NULL,
              user_id             VARCHAR(80),
              redirect_uri        VARCHAR(2000),
              expires             TIMESTAMP      NOT NULL,
              scope               VARCHAR(4000),
              id_token            VARCHAR(1000),
              PRIMARY KEY (authorization_code)
            );

            CREATE TABLE {$this->config['refresh_token_table']} (
              refresh_token       VARCHAR(40)    NOT NULL,
              client_id           VARCHAR(80)    NOT NULL,
              user_id             VARCHAR(80),
              expires             TIMESTAMP      NOT NULL,
              scope               VARCHAR(4000),
              PRIMARY KEY (refresh_token)
            );

            CREATE TABLE {$this->config['user_table']} (
              tel_nr              VARCHAR(80),
              password            VARCHAR(80),
              first_name          VARCHAR(80),
              last_name           VARCHAR(80),
              tel_nr_verified     BOOLEAN,
              scope               VARCHAR(4000)
            );

            CREATE TABLE {$this->config['scope_table']} (
              scope               VARCHAR(80)  NOT NULL,
              is_default          BOOLEAN,
              PRIMARY KEY (scope)
            );

            CREATE TABLE {$this->config['jwt_table']} (
              client_id           VARCHAR(80)   NOT NULL,
              subject             VARCHAR(80),
              public_key          VARCHAR(2000) NOT NULL
            );

            CREATE TABLE {$this->config['jti_table']} (
              issuer              VARCHAR(80)   NOT NULL,
              subject             VARCHAR(80),
              audiance            VARCHAR(80),
              expires             TIMESTAMP     NOT NULL,
              jti                 VARCHAR(2000) NOT NULL
            );

            CREATE TABLE {$this->config['public_key_table']} (
              client_id            VARCHAR(80),
              public_key           VARCHAR(2000),
              private_key          VARCHAR(2000),
              encryption_algorithm VARCHAR(100) DEFAULT 'RS256'
            )
        ";

        return $sql;
    }

```