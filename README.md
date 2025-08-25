# Super Secret Agency - Test DOEO

Cette application utilise une architecture moderne avec :
- **Backend** : API Platform 4.1 avec Symfony et FrankenPHP
- **Frontend** : Application Nuxt.js 4.1 avec Quasar
- **Base de données** : PostgreSQL 16
- **Conteneurisation** : Docker Compose

## 🚀 Démarrage rapide

### Prérequis
- Docker et Docker Compose

### Développement
Lancer les conteneurs :
```bash
docker compose up --wait
```
Les serveurs sont lancés automatiquement.

**Attention** : Absence de hotreload pour le frontend !

Pour redémarrer le frontend :
```bash
docker-compose restart pwa
```


#### URLs d'accès
- **Documentation API** : http://localhost/api/docs
- **Frontend** : http://localhost:3000
- **API** : http://localhost/api
- **Base de données** : localhost:5432

## 🏗️ Architecture

### Services
- **php** : Backend API Platform avec FrankenPHP
- **pwa** : Frontend Nuxt.js
- **database** : Base de données PostgreSQL

## 📚 Documentation

- [API Platform](https://api-platform.com/)
- [FrankenPHP](https://frankenphp.dev/)
- [Symfony](https://symfony.com/)
- [Nuxt.js](https://nuxt.com/)
- [Quasar](https://quasar.dev/docs/)
