# Dockerfile do frontend (Node.js)
FROM node:16

# Definir o diretório de trabalho
WORKDIR /app

# Copiar os arquivos do frontend
COPY . .

# Instalar as dependências do frontend
RUN npm install

# Expor a porta
EXPOSE 3000

# Definir o comando para rodar a aplicação
CMD ["npm", "start"]
