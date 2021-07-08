FROM atlastechnologiesteam/cate_base:latest as fm-cate

ARG newuser
RUN useradd -ms /bin/bash $newuser
RUN mkdir -p /home/$newuser/.composer && \
    chown -R $newuser:$newuser /home/$newuser
# Set working directory
WORKDIR /var/www
USER $newuser
