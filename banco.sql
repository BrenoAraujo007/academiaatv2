CREATE DATABASE academibanc;
USE academibanc;

CREATE DATABASE academia;
USE academia;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  cpf VARCHAR(11) NOT NULL UNIQUE,
  pago BOOLEAN NOT NULL DEFAULT 0,
  valor_pagamento DECIMAL(10, 2),
  frequencia VARCHAR(255),
  ultimo_pagamento DATE
);


CREATE TABLE login(
id INT AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(100),
senha VARCHAR(100)
);

INSERT INTO login (email, senha) VALUES ('brenin@123', 'breno3');
