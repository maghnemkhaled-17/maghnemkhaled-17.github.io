-- Fichier: database.sql
CREATE DATABASE IF NOT EXISTS gestion_courriers;
USE gestion_courriers;

CREATE TABLE IF NOT EXISTS courriers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('départ', 'arrivé') NOT NULL,
    datetime DATETIME NOT NULL,
    number VARCHAR(50) UNIQUE NOT NULL,
    destinataire VARCHAR(255),
    expediteur VARCHAR(255),
    reference VARCHAR(100),
    division VARCHAR(100),
    departement VARCHAR(100),
    objet TEXT,
    dossier VARCHAR(100),
    sous_dossier VARCHAR(100),
    fichier_pdf VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insérer des données de test
INSERT INTO courriers (type, datetime, number, destinataire, expediteur, objet, division, departement) VALUES
('départ', NOW(), 'D-1001', 'Service RH', NULL, 'Rapport annuel', 'Direction Générale', 'Administration'),
('arrivé', NOW(), 'A-2001', NULL, 'Client Externe', 'Devis projet', 'Direction Commerciale', 'Commercial');