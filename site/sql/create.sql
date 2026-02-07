DROP EXTENSION citextl;
DROP TABLE utilisateurs;


CREATE EXTENSION IF NOT
EXISTS citext;

CREATE TABLE utilisateurs (
    id SERIAL PRIMARY KEY,
    nom_utilisateur VARCHAR(255) NOT NULL
);