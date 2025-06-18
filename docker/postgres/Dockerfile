FROM postgres:15-alpine

ENV POSTGRES_DB=lmfrotas
ENV POSTGRES_USER=user
ENV POSTGRES_PASSWORD=secret

COPY ./docker/postgres/init.sql /docker-entrypoint-initdb.d/

EXPOSE 5432

CMD ["postgres"]