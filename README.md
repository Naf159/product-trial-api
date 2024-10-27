# Product Trial API

## Installation
composer install

## Changer les accès de la base de données sur .env
DATABASE_URL="mysql://root@127.0.0.1:3306/product_api?serverVersion=8&charset=utf8mb4"

## Remplir la base de données (data dump)
php bin/console doctrine:fixtures:load

## Lancer le serveur
php bin/console server:start

## Tests POSTMAN

### Récupération de tout les produits
GET http://127.0.0.1:8000/products

### Récupération d'un produit
GET http://127.0.0.1:8000/products/9

### Création d'un nouveau produit POST
POST http://127.0.0.1:8000/products
{
"code": "P0001",
"name": "Product 01",
"description": "Description for Product 20",
"image": "image1.png",
"category": "Category01",
"price": 10.0,
"quantity": 99,
"internalReference": "INT-0001",
"shellId": 1,
"rating": 4,
"inventoryStatus": "INSTOCK"
}

### Modification d'un produit PATCH
`PATCH http://127.0.0.1:8000/products/2
{
"code": "P002",
"name": "Product 2 (updated)",
"description": "Description for Product 2 (updated)",
"image": "image1.png",
"category": "Category10",
"price": 10.0,
"quantity": 99,
"internalReference": "INT-001",
"shellId": 1,
"rating": 4,
"inventoryStatus": "INSTOCK"
}`
### Suppression d'un produit
`DELETE http://localhost:8080/api/products/4`






{
"code": "P002",
"name": "Product 2 (updated)",
"description": "Description for Product 2 (updated)",
"image": "image1.png",
"category": "Category10",
"price": 10.0,
"quantity": 99,
"internalReference": "INT-001",
"shellId": 1,
"rating": 4,
"inventoryStatus": "INSTOCK"
}