CREATE USER postgres_test WITH PASSWORD '123123' CREATEDB;
CREATE DATABASE postgres_test
    WITH
    OWNER = postgres_test
    ENCODING = 'UTF8'
    LC_COLLATE = 'en_US.utf8'
    LC_CTYPE = 'en_US.utf8'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;