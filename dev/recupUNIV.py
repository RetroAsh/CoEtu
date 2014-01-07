from bs4 import BeautifulSoup
import urllib.request

url = "http://www.enseignementsup-recherche.gouv.fr/cid20269/liste-des-universites.html"
page = urllib.request.urlopen(url).read()

def is_link_to_university(tag):
        return tag.name == 'a' and tag.has_attr('class') and tag['class'] == ['chevron']

soup = BeautifulSoup(page)

p = soup.findAll(is_link_to_university)

for i in range(len(p) - 2):
    link = p[i]
    with open("univ.sql", mode='a', encoding='utf-8') as file:
        lib = link.get_text()
        if lib == " Besançon":
            lib = "Universités de l'académie de Besançon"
        lib = lib.replace("'", "''")
        file.write("INSERT INTO `universite` (`id_univ`, `nom_univ`) VALUES (" +
                   str(i+1) + ", '" + str(lib) + "');\n")

    urlUniv = link.get('href')
    if urlUniv[0] == '/':
        urlUniv = "http://www.enseignementsup-recherche.gouv.fr" + urlUniv
    pageUniv = urllib.request.urlopen(urlUniv).read()
    soupUniv = BeautifulSoup(pageUniv)

    u = soupUniv.findAll(is_link_to_university)
    s = soupUniv.findAll('strong')

    for j in range(len(u)):
        with open("campus.sql", mode='a', encoding='utf-8') as file:
            camp = s[j].get_text() + u[j].get_text() if s else u[j].get_text()
            camp = camp.replace("'", "''")
            file.write("INSERT INTO `campus` (`id_camp`, `id_ville`, `id_univ`, `libelle`) VALUES (NULL, , " + str(i+1) + ", '" + camp + "');\n")

