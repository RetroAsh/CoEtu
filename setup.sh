#!/bin/bash

echo "Installation de CoEtu"

file="CoEtu"

case $# in
     0) a=0
        url="https://github.com/Ricain/CoEtu.git";;
     1) if [ $1 = "-a" ]
        then
            a=1
            url="https://github.com/Ricain/CoEtu/archive/master.zip"
        else
            echo "USAGE : setup.sh [-a]"
            exit 1
        fi;;
    *) echo "USAGE : setup.sh [-a]";;
esac

echo -n "Choisisser le dossier de destination : " ; read path
mkdir -p $path

echo -n "Entrée votre identifiant mysql       : " ; read id

stringsql="mysql -u $id"

echo -n "Entrée votre mot de passe mysql      : " ; read mdp

if [ ".${mdp}" != "." ]
then
    stringsql=${stringsql}" -p${mdp}"
fi
echo -n "Entrée votre serveur mysql           : " ; read server

echo "Téléchargement du projet"

if [ $a -eq 0 ]
then
    git clone $url ${path}/$file 
else
    where=$(pwd)
    cd /tmp
    wget $url 1>/dev/null
    unzip master.zip 1>/dev/null
    cd $where
    mv /tmp/CoEtu-master ${path}/$file
fi

stringsql=$stringsql" < ${path}/${file}/dev/projetbdd.sql"

echo "Import de la base de données"

bash -c "${stringsql}"

echo "Création du fichier de login"

echo "<?php
          define(\"LOGIN\",\"${id}\");
          define(\"PASSWORD\",\"${mdp}\");
          define(\"BASE\",\"coetu\");
          define(\"SERVER\",\"${server}\");
      ?>" > $path/$file/login.inc

echo "Installation terminé"
