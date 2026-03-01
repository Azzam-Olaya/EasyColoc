# Lancer EasyColoc avec Docker

Logique du projet : [Brief-Crois-EasyColoc](https://github.com/Gourita-M/Brief-Crois-EasyColoc) — gestion de colocation, dépenses partagées, « qui doit à qui », invitations, admin global. Données stockées dans **PostgreSQL** (visibles dans pgAdmin).

## 1. Prérequis

- Docker et Docker Compose installés
- Fichier `.env` à la racine du projet (copier depuis `.env.example` si besoin)

Dans `.env`, garde au minimum :

- `DB_CONNECTION=pgsql`
- `DB_HOST=postgres`
- `DB_PORT=5432`
- `DB_DATABASE=easycoloc`
- `DB_USERNAME=postgres`
- `DB_PASSWORD=...` (même mot de passe que dans `docker-compose` pour PostgreSQL)

Si tu mets `DB_PASSWORD=postgres` dans `.env`, le `docker-compose.yml` utilise déjà `${DB_PASSWORD:-postgres}` pour le conteneur Postgres.

## 2. Recréer les conteneurs et la base

```bash
# Depuis le dossier EasyColoc (là où se trouve docker-compose.yml)
docker compose build --no-cache
docker compose up -d
```

Cela crée :

- **app** (Laravel) → http://localhost:8000  
- **postgres** (PostgreSQL 16) → port 5433 en local (5432 dans le réseau Docker)  
- **pgadmin** → http://localhost:5055  

Les données Postgres sont dans le volume `pgdata` (persistantes même si tu supprimes les conteneurs).

## 3. Migrations (tables en base)

Après le premier `up` :

```bash
docker compose exec app php artisan migrate --force
```

À faire une fois après chaque « recréation » de la base (nouveau volume ou première fois).

## 4. Clé d’application (si besoin)

Si `APP_KEY` est vide dans `.env` :

```bash
docker compose exec app php artisan key:generate
```

## 5. Utilisation

- **App** : http://localhost:8000  
  - Inscription → premier compte = admin global  
  - Colocation → créer une colocation, inviter, dépenses, « qui doit à qui », marquer payé  

- **pgAdmin** : http://localhost:5055  
  - Email : `admin@admin.com`  
  - Mot de passe : `admin`  
  - Ajouter un serveur : host = `postgres`, port = `5432`, user = `postgres`, mot de passe = celui de `DB_PASSWORD` dans `.env`  
  - Base : `easycoloc`  

## 6. Commandes utiles

```bash
# Arrêter
docker compose down

# Arrêter et supprimer les volumes (efface les données Postgres)
docker compose down -v

# Voir les logs
docker compose logs -f app
```

Après avoir supprimé conteneurs et données, refaire les étapes **2** et **3** pour tout recréer avec la même logique EasyColoc.
