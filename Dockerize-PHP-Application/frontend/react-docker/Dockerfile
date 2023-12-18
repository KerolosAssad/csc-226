# Use the official Node.js image with a specified version
FROM node:14-alpine

# Set the working directory inside the container
WORKDIR /app

# Add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# Copy the package.json and package-lock.json files to the container
COPY package.json package-lock.json /app/

# Install app dependencies
RUN npm install

# Install create-react-app globally
RUN npm install -g create-react-app

# Copy the entire application to the container
COPY . /app/

# Install Material-UI and other dependencies
RUN npm install @mui/material @emotion/react @emotion/styled

RUN npm run build

# Start the application
CMD ["npm", "start"]
