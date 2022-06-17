FROM node:16.15.1

# COPY --chown=1000:1000 app/node_modules /usr/src/app/node_modules

WORKDIR /usr/src/app

RUN yarn install

CMD ["sh", "-c", "yarn install && yarn run dev"]

USER 1000:1000