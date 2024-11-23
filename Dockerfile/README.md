# docker-acunetix

![DockerFile](https://img.shields.io/badge/DockerFile-20200128-blue)
![Acunetix](https://img.shields.io/badge/Acunetix-12.0.190325161(20190525)-blue)

## 使用手冊

基於 Ubuntu 18.04 映像建立 Acunetix 12 試用版的執行環境

```text
URL: https://localhost:13443 (SSL Only)
Account: scan@awvs.com
Password: Awvs2020
```

### Build & Push

```bash
docker build -t docker-acunetix:190325161 .
docker tag docker-acunetix:190325161 docker-acunetix:latest
docker push registry.com/docker-acunetix:latest
```

### Pull & Run

```bash
docker pull registry.com/docker-acunetix:latest
docker run -d -p 13443:13443 --name docker-acunetix --restart always registry.com/docker-acunetix:latest
```

### Attach & update & logs

```bash
docker attach docker-acunetix
docker exec -u 0 -it docker-acunetix bash
docker update --restart always docker-acunetix
docker logs docker-acunetix
```

## System Requirements

[官方說明](https://www.acunetix.com/support/docs/wvs/installing-acunetix-wvs/)

* Supported Operating systems
* Microsoft Windows 7 or Windows 2008 R2 and later
* Ubuntu Desktop/Server 16.0.4 LTS or higher
* Suse Linux Enterprise Server 15 and openSUSE Leap 15.0
* Kali Linux versions 2018.4 and 2019.1
* We are actively testing other Linux distributions. Please let us know if you have requests for specific distros.
* CPU: 64 bit processor
* System memory: minimum of 2 GB RAM
* Storage: 1 GB of available hard-disk space.
* This does not include the storage required to save the scan results - this will depend on the level of usage of Acunetix.

## Installation on Linux

1. Download the latest Linux version of Acunetix from the download location provided when you purchased the license.
2. Open a Terminal Windows
3. Use chmod to add executable permissions on the installation file
    `E.g. chmod +x acunetix_12.0.181115088_x64.sh`
4. Run the installation
    `E.g. sudo ./acunetix_12.0.181115088_x64.sh`
5. In case there are dependencies missing see the Notes section
6. Review and accept the License Agreement.
7. Configure the hostname which will be used to access the Acunetix UI
8. Provide credentials for the Administrative user account. These will be used to access and configure Acunetix.
9. Proceed with the installation.

Notes:
The following need to be installed if you are installing Acunetix on Linux where the Linux GUI is not installed.

```bash
sudo apt-get install libxdamage1 libgtk-3-0 libasound2 libnss3 libxss1 libx11-xcb1
```
