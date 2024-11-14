# Dockerfile para o frontend Vue.js
FROM node:16

WORKDIR /app

COPY package*.json ./

# Instalar dependências do Vue.js
RUN npm install

COPY . .

EXPOSE 8080

CMD ["npm", "run", "serve"]