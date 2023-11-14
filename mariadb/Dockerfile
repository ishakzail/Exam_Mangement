FROM debian:buster

RUN apt-get update && \
    apt-get install mariadb-server -y

EXPOSE 3306

COPY ./tools/database.sql /tmp/

RUN service mysql start && mysql -u root < /tmp/database.sql

COPY ./conf/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf
 
ENTRYPOINT ["mysqld"]