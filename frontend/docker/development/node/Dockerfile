# base image
FROM node:14.15.1-alpine

# install chrome for protractor tests
RUN apk update  && apk add chromium bash
# set working directory
WORKDIR /app
## add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

USER node
