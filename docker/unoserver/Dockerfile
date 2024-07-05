FROM ghcr.io/unoconv/unoserver-docker
USER root

RUN apk upgrade
RUN apk add py3-pip
USER worker
RUN pip install --break-system-packages unoserver -U
