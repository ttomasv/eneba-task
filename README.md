# Kaip naudotis aplikacija?
### Reikalavimai
-  PHP ">=7.2.5"
-  Symfony "5.1.*"
-  Yarn ">=1.22.4"
-  Composer ">=1.10.10"

### Norint lokaliai paleisti aplikaciją, reikia atlikti šiuos veiksmus:
   Prieš pradedant, terminale išsirinkti vietą, kurioje norima saugoti aplikacijos failus.
1. git clone https://github.com/ttomasv/eneba-task.git
2. cd eneba-task
3. Turite redaguoti .env failą (vardą ir slaptažodį turite žinoti, o db_pavadinimas bus sukurtas toks, kokį įrašysite)
##### DATABASE_URL=mysql://JŪSŲ_PRISIJUNGIMO_VARDAS_MYSQL_DB:JŪSŲ_SLAPTAŽODIS@127.0.0.1:3306/DB_PAVADINIMAS?serverVersion=5.7
4. composer install
5. yarn install
6. php bin/console doctrine:database:create
7. php bin/console doctrine:schema:update --force
8. symfony server:start -d
9. yarn build
#### Atlikus šiuos veiksmus, naršyklėje aplikacija pasieksite adresu: http://localhost:8000/
#### Aplikacija viešai prieinama šiuo adresu: http://whoops.lt
