FROM ubuntu:latest  

RUN apt-get update  
RUN apt-get install -y nginx  

WORKDIR /var/www/html/fakestore 

VOLUME /var/www/html/fakestore

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]