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

### Démo

Lancer les conteneurs :
```bash
docker compose up --wait
```

Pour charger un set de données : 
```bash
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

#### URLs d'accès
- **Documentation API** : http://localhost/docs
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

## Développement

### Debug 

Pour lancer l'analyse de [PHPStan](https://phpstan.org/) :

```bash
vendor/bin/phpstan analyse src
```

### TodoList

#### Devops

- [x] Stack de développemnt :
    - [x] Apiplatform + FrankenPHP,
    - [x] Nuxt.js,
    - [x] Quasar,
- [ ] Déployer sur server perso :
    - [ ] dns,
    - [ ] yaml swarm,
    - [ ] mise à jour des script de deployement.

#### API 

- [ ] Routes de récupération.
    - [ ] User, utilisé SecurityBundle.
    - [x] Agent
    - [x] Mission
    - [x] Country
    - [ ] MissionResult
    - [ ] Message
- [ ] Route d'édition.
    - [ ] User
    - [ ] Agent
    - [x] Mission
    - [ ] Country
    - [ ] Message
    - [ ] MissionResult
- [ ] Chaque Agent peut avoir un autre Agent comme mentor 
- [x] Chaque Agent peut infiltrer un seul pays à la fois 


#### Web

...
