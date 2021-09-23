#############
### build ###
#############
# base image
FROM node:14.17.6-alpine as build

ARG BACKEND_API_URL

RUN apk update  && apk --no-cache add bash

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install and cache app dependencies
COPY package.json /app/package.json
RUN npm install

# add app
COPY . /app

# generate build
RUN npm run build

############
### prod ###
############

# base image
FROM nginx:1.21.0-alpine

# copy artifact build from the 'build environment'
COPY --from=build /app/dist /usr/share/nginx/html
COPY ./docker/production/nginx/conf.d /etc/nginx/conf.d

# expose port 80
EXPOSE 80

# run nginx
CMD ["nginx", "-g", "daemon off;"]
