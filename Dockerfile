FROM atlastechnologiesteam/cate_base:7.3 as fm-cate
ARG user

RUN if [ $user != 'root' ]; then \
      useradd -G www-data,root -d /home/$user $user; \
      mkdir -p /home/$user/.composer && \
      chown -R $user:$user /home/$user; \
    fi
RUN adduser $user sudo \
&&  echo "${user}     ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

USER $user
