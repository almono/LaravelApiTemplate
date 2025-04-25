FROM node:alpine

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json first (for better caching of dependencies)
COPY package*.json ./

# Install dependencies inside the container
RUN npm install

# Copy the rest of the frontend files
COPY . .

CMD ["npm", "run", "dev"]