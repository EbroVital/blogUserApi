# 📝 Blog API – Laravel

Une API RESTful de blog développée avec **Laravel**, permettant la gestion des utilisateurs, des articles et des interactions (authentification, publications, etc.).  
Ce projet est conçu pour servir de **backend** à une application web ou mobile.

---

## 🚀 Fonctionnalités

- 🔐 Authentification des utilisateurs (register / login / logout)
- 👤 Gestion des profils utilisateurs
- 📝 Création, modification, suppression des articles
- 📄 Consultation des articles
- 🔒 Sécurisation des routes via middleware
- 📦 API RESTful (JSON)
- 🕒 Gestion des dates et timestamps
- ✅ Validation des données

---

## 🛠️ Technologies utilisées

- **PHP 8+**
- **Laravel**
- **MySQL**
- **Laravel Sanctum / Passport** (selon ton choix)
- **Composer**
- **Insomnia** (pour les tests)

---

## ⚙️ Installation
1. **Cloner le dépôt**
```bash
git clone https://github.com/EbroVital/blogUserApi.git
cd blogUserApi
```
2. **Installer les dépendances**
```bash
composer install
```
3. **Configurer l’environnement**
```bash
cp .env.example .env
php artisan key:generate
```
4. **Configurer la base de données**
Modifier les informations dans le fichier .env :
```bash
DB_DATABASE=blog_api
DB_USERNAME=root
DB_PASSWORD=
```
5. **Exécuter les migrations**
```bash
php artisan migrate
```
6. **Lancer le serveur**
```bash
php artisan serve
```
## 🔑 Authentification
L’API utilise une authentification basée sur token.
Exemple de header :
```bash
Authorization: Bearer VOTRE_TOKEN
```
## 📌 Endpoints principaux (exemples)
| Méthode | Endpoint        | Description          |
| ------- | --------------- | -------------------- |
| POST    | /api/register   | Inscription          |
| POST    | /api/login      | Connexion            |
| GET     | /api/posts      | Liste des articles   |
| POST    | /api/posts/create      | Créer un article     |
| PUT     | /api/posts/edit/{id} | Modifier un article  |
| DELETE  | /api/posts/{id} | Supprimer un article |

## 🧪 Tests
Les endpoints peuvent être testés avec :
- Postman
- Insomnia

