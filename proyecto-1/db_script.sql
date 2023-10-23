-- Creación de base de datos
CREATE DATABASE clientsdb;

-- Creación de tabla de clients
CREATE TABLE CLIENTS(
    line BIGINT PRIMARY KEY,
    document BIGINT UNIQUE NOT NULL,
    document_type VARCHAR(30) NOT NULL,
    name VARCHAR(50) NOT NULL,
    city VARCHAR(30) NOT NULL,
    email VARCHAR(60) NOT NULL
);

-- Creación de tabla de contracts
CREATE TABLE CONTRACTS(
    code BIGINT PRIMARY KEY,
    client_line BIGINT,
    activated_at DATE NOT NULL,
    price BIGINT NOT NULL,
    status VARCHAR(30) NOT NULL,
    CONSTRAINT fk_client
        FOREIGN KEY(client_line) 
        REFERENCES CLIENTS(line)
);

-- Creación de tabla de payments
CREATE TABLE PAYMENTS(
    id SERIAL PRIMARY KEY,
    contract_code BIGINT,
    amount BIGINT NOT NULL,
    created_at TIMESTAMP,
    CONSTRAINT fk_contract
        FOREIGN KEY(contract_code) 
        REFERENCES CONTRACTS(code)
);

