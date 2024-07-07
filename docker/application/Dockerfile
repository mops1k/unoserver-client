FROM ghcr.io/mops1k/php-cli-dev-docker:v8.3

RUN apk update \
    && apk add --no-cache \
    bash curl \
    py3-pip \
    libreoffice

RUN rm -rf /var/cache/apk/* && \
    rm -rf /tmp/*

# renovate: datasource=repology depName=temurin-17-jdk versioning=loose
ARG VERSION_ADOPTIUM_TEMURIN="17.0.7_p7-r0"

# install Eclipse Temurin JDK
RUN curl https://packages.adoptium.net/artifactory/api/security/keypair/public/repositories/apk -o /etc/apk/keys/adoptium.rsa.pub && \
    echo 'https://packages.adoptium.net/artifactory/apk/alpine/main' >> /etc/apk/repositories && \
    apk update && apk add temurin-17-jdk=${VERSION_ADOPTIUM_TEMURIN}

ARG PYTHONPATH="/usr/bin/python3:/usr/lib/libreoffice/program"
ENV PYTHONPATH=${PYTHONPATH}

RUN pip install --break-system-packages unoserver
