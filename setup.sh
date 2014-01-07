#!/bin/bash


file="CoEtu"

case $# in
     0) a=0
        url="https://github.com/Ricain/CoEtu.git"
        echo -n "git : "
        if [ ".$(command -v git)" = "." ]
        then
            echo "non disponible"
            exit 1
        else
            echo "disponible"
        fi;;
     1) if [ $1 = "-a" ]
        then
            a=1
            url="https://github.com/Ricain/CoEtu/archive/master.zip"
            echo -n "unzip : "
            if [ ".$(command -v unzip)" = "." ]
            then
                echo "non disponible"
                exit 1
            else
                echo "disponible"
            fi
            echo -n "wget  : "
            if [ ".$(command -v wget)" = "." ]
            then
                echo "non disponible"
                echo -n "curl  : "
                if [ ".$(command -v curl)" = "." ]
                then
                    echo "non disponible"
                    exit 1
                else
                    echo "disponible"
                    prog="curl -L"
                    ifcurl="> master.zip"
                fi
            else
                echo "disponible"
                prog="wget"
            fi
        else
            if [ $1 = "-h" ]
            then
                echo "USAGE : setup.sh [-a]"
                echo "-a : utilisation de wget/curl"
                exit 0
            else
                echo "USAGE : setup.sh [-a]"
                exit 1
            fi
        fi;;
    *) echo "USAGE : setup.sh [-a]";;
esac
echo "Installation de CoEtu"
echo -n "Choisisser le dossier de destination : " ; read path

echo -n "Entrée votre identifiant mysql       : " ; read id

stringsql="mysql -u $id"

echo -n "Entrée votre mot de passe mysql      : " ; read mdp

if [ ".${mdp}" != "." ]
then
    stringsql=${stringsql}" -p${mdp}"
fi
echo -n "Entrée votre serveur mysql           : " ; read server

echo "Téléchargement du projet"
mkdir -p $path
if [ $a -eq 0 ]
then
    git clone $url ${path}/$file 
else
    where=$(pwd)
    cd /tmp
    bash -c "${prog} $url ${ifcurl}"
    unzip master.zip 1>/dev/null
    cd $where
    mv /tmp/CoEtu-master ${path}/$file
    rm -f /tmp/master.zip
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
