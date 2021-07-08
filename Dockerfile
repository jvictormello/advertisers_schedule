FROM atlastechnologiesteam/cate_base:latest as fm-cate

ARG newuser
RUN if [ ${newuser} != 'root' ]; then useradd -ms /bin/bash $newuser &&\
    mkdir -p /home/$newuser/.composer && \
    chown -R $newuser:$newuser /home/$newuser && \
    echo "${newuser} ALL=(ALL:ALL) ALL" >> /etc/sudoers; fi
# Set working directory
WORKDIR /var/www
USER $newuser
