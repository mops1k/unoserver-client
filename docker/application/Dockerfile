FROM jitesoft/phpunit:8.3 as base

RUN apk update \
    && apk add --no-cache \
    bash curl \
    py3-pip

RUN pip install unoserver
