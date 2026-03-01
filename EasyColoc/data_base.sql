-- ===============================
-- Créer la base de données
-- ===============================
CREATE DATABASE easycoloc;
\c easycoloc;

-- ===============================
-- TABLE UTILISATEUR (User)
-- ===============================
CREATE TABLE Utilisateur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL CHECK(role IN ('Member','Owner','Admin')),
    score_reputation INT DEFAULT 0,
    est_banni BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT NOW(),
    date_modification TIMESTAMP DEFAULT NOW()
);

-- ===============================
-- TABLE Member
-- ===============================
CREATE TABLE Member (
    id SERIAL PRIMARY KEY,
    utilisateur_id INT NOT NULL REFERENCES Utilisateur(id) ON DELETE CASCADE
);

-- ===============================
-- TABLE Owner
-- ===============================
CREATE TABLE Owner (
    id SERIAL PRIMARY KEY,
    utilisateur_id INT NOT NULL REFERENCES Utilisateur(id) ON DELETE CASCADE
);

-- ===============================
-- TABLE Admin
-- ===============================
CREATE TABLE Admin (
    id SERIAL PRIMARY KEY,
    utilisateur_id INT NOT NULL REFERENCES Utilisateur(id) ON DELETE CASCADE
);

-- ===============================
-- TABLE COLLOCATION
-- ===============================
CREATE TABLE Collocation (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    id_owner INT NOT NULL REFERENCES Owner(utilisateur_id) ON DELETE CASCADE,
    statut VARCHAR(20) DEFAULT 'active' CHECK(statut IN ('active','annulee')),
    date_annulation TIMESTAMP NULL,
    date_creation TIMESTAMP DEFAULT NOW()
);

-- ===============================
-- TABLE CATEGORIE
-- ===============================
CREATE TABLE Categorie (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- ===============================
-- TABLE DEPENSE
-- ===============================
CREATE TABLE Depense (
    id SERIAL PRIMARY KEY,
    id_collocation INT NOT NULL REFERENCES Collocation(id) ON DELETE CASCADE,
    id_payeur INT NOT NULL REFERENCES Utilisateur(id) ON DELETE CASCADE,
    id_categorie INT REFERENCES Categorie(id) ON DELETE SET NULL,
    titre VARCHAR(150) NOT NULL,
    montant NUMERIC(12,2) NOT NULL,
    date_depense TIMESTAMP DEFAULT NOW()
);

-- ===============================
-- TABLE PAIEMENT
-- ===============================
CREATE TABLE Paiement (
    id SERIAL PRIMARY KEY,
    id_depense INT NOT NULL REFERENCES Depense(id) ON DELETE CASCADE,
    id_payeur INT NOT NULL REFERENCES Utilisateur(id) ON DELETE CASCADE,
    montant NUMERIC(12,2) NOT NULL,
    date_paiement TIMESTAMP DEFAULT NOW()
);

-- ===============================
-- TABLE INVITATION
-- ===============================
CREATE TABLE Invitation (
    id SERIAL PRIMARY KEY,
    id_expediteur INT NOT NULL REFERENCES Owner(utilisateur_id) ON DELETE CASCADE,
    id_destinataire INT NOT NULL REFERENCES Member(utilisateur_id) ON DELETE CASCADE,
    id_collocation INT NOT NULL REFERENCES Collocation(id) ON DELETE CASCADE,
    jeton VARCHAR(255) UNIQUE NOT NULL,
    statut VARCHAR(20) DEFAULT 'en_attente' CHECK(statut IN ('en_attente','accepte','refuse')),
    date_creation TIMESTAMP DEFAULT NOW()
);

-- ===============================
-- TABLE MEMBRE_COLLOCATION
-- ===============================
CREATE TABLE Member_Collocation (
    id SERIAL PRIMARY KEY,
    id_member INT NOT NULL REFERENCES Member(utilisateur_id) ON DELETE CASCADE,
    id_collocation INT NOT NULL REFERENCES Collocation(id) ON DELETE CASCADE,
    role VARCHAR(20) DEFAULT 'Member' CHECK(role IN ('Member','Owner','Admin')),
    date_join TIMESTAMP DEFAULT NOW(),
    date_quit TIMESTAMP NULL,
    UNIQUE(id_member, id_collocation)
);

-- ===============================
-- TABLE NOTIFICATION
-- ===============================
CREATE TABLE Notification (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL REFERENCES Utilisateur(id) ON DELETE CASCADE,
    message TEXT NOT NULL,
    lu BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT NOW()
);