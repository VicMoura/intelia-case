# Dockerfile para o frontend Vue.js
FROM node:16.20.2

WORKDIR /app

COPY package*.json ./

RUN ls -l /app 

RUN npm install

RUN npm i @vue/cli-service

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . .

EXPOSE 8080

CMD ["npm", "run", "serve"]