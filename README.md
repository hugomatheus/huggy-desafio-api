# Desafio Huggy


## Configuração backend (Laravel)
### Clonar o repositório
```bash
git clone https://github.com/hugomatheus/huggy-desafio-api.git
cd huggy-desafio-api
```

### Criar o app na Huggy
No painel da Huggy, crie um novo aplicativo e configure o URL de redirecionamento com:

```bash
http://localhost:8888/auth/huggy/callback
```
### Arquivo .env
Copie o arquivo .env.example para .env:

```bash
cp .env.example .env
```
Preencha com as credenciais fornecidas pela Huggy:

```bash
#DB
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=huggy
DB_USERNAME=root
DB_PASSWORD=root


#HUGGY
HUGGY_CLIENT_ID= # fornecido pela Huggy
HUGGY_CLIENT_SECRET= # fornecido pela Huggy

HUGGY_BASE_AUTH_URL=https://auth.huggy.app/oauth
HUGGY_REDIRECT_URL=http://localhost:8888/auth/huggy/callback
HUGGY_BASE_API_URL=https://api.huggy.app
HUGGY_API_VERSION=v3

#EMAIL
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=contato@email.com
MAIL_FROM_NAME="Desafio Huggy"

APP_FRONTEND=http://localhost:5173
```

### Subir o ambiente
```bash
docker compose up -d
docker compose exec api bash
composer install
php artisan key:generate
php artisan migrate
```
### Iniciar o worker - Envio de e-mail
Dentro do container da API:

```bash
php artisan queue:work
```
## Configurar Webhooks com Ngrok
Instale o Ngrok.

Rode o túnel HTTP para sua API:

```bash
ngrok http http://localhost:8888
```

Copie a URL exibida na propriedade Forwarding, exemplo:
https://0667-192-140-116-228.ngrok-free.app
Cadastre o webhook no painel da Huggy com o seguinte endpoint:

https://<SEU_NGROK>.ngrok-free.app/huggy/webhooks


## Configuração do Frontend (vue)

Node v22

### Clonar o repositório
```bash
git clone https://github.com/hugomatheus/huggy-desafio-frontend.git
cd huggy-desafio-frontend
```
## Arquivo .env
Copie o exemplo e configure:

```bash
cp .env.example .env
```
### Instalar dependências e rodar
```bash
npm install
npm run dev
```
### Acessar
http://localhost:5173/login
