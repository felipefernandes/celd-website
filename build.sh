#!/bin/bash
echo -e "\nCELD - wordpress"
echo -e "================================"
echo -e "Instanciamento e construção docker...\n"

# Instanciamento
docker-compose up -d --remove-orphans

# espera o wordpress ficar pronto
sleep 20

# Instalação do Wordpress
echo -e "\n\nInstalação wordpress...\n"
docker run -it --rm --volumes-from celd-wp --network container:celd-wp wordpress:cli \
wp core install --url="localhost:9001" --title="CELD - Centro Espírita Leon Denis" --admin_user="celd" --admin_password="letscode" \
--admin_email="admin@celd.org.br" --skip-email

echo -e "\n\nHabilitando plugins...\n"
docker run -it --rm --volumes-from celd-wp --network container:celd-wp wordpress:cli \
wp plugin activate acf-to-wp-api advanced-custom-fields acf-repeater bootstrap-for-contact-form-7 \
contact-form-7 contact-form-7-to-database-extension custom-post-type-ui json-api popup-maker \
recent-posts-widget-with-thumbnails wp-pagenavi wp-smushit 

echo -e "\n\nHabilitando tema CELD...\n"
docker run -it --rm --volumes-from celd-wp --network container:celd-wp wordpress:cli \
wp theme activate celd_2016

echo -e "\n"
echo -e "+----------+-----------------------+"
echo -e "+ Instalação INFOS   		        +"
echo -e "+----------+-----------------------+"
echo -e "+ hostname | http://localhost:9001 +"
echo -e "+----------+-----------------------+"
echo -e "+ username | celd 		            +"
echo -e "+----------+-----------------------+"
echo -e "+ password | letscode 	            +"
echo -e "+----------+-----------------------+"
echo -e "\n"
echo -e "Bye!\n"