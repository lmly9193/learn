FROM ubuntu:18.04

ARG DEBIAN_FRONTEND=noninteractive

ENV TZ=Asia/Taipei
ENV hostname=localhost
ENV awvs_email=scan@awvs.com
ENV awvs_password=Awvs2020

RUN apt-get update
RUN apt-get install -y libxdamage1 libgtk-3-0 libasound2 libnss3 libxss1 libx11-xcb1 sudo cron expect

WORKDIR /tmp/
COPY acunetix_trial.sh .
RUN chmod +x acunetix_trial.sh && sh -c '/bin/echo -e "\nyes\n${hostname}\n${awvs_email}\n${awvs_password}\n${awvs_password}\n" | ./acunetix_trial.sh'

COPY once.expect .
RUN chmod +x once.expect && su -l acunetix -c /tmp/once.expect

WORKDIR /home/acunetix/.acunetix_trial/v_190325161/scanner/
COPY patch_awvs .
RUN ./patch_awvs

WORKDIR /etc/cron.d/
COPY crontab awvs-cron
RUN chmod +rx awvs-cron

CMD cron && su -l acunetix -c /home/acunetix/.acunetix_trial/start.sh
