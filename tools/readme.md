# Générateur de documentation & scripts FAROS VERSION help

### Les fichiers
* **tools/generator_versions_docs.php** --> le script php à déclencher, qui se base sur les fichiers json basé dans le dossier /versions_data et les templates /templates
* **tools/templates/check_version_script_template.php** --> le template du script PHP offert aux hébergeurs afin de tester leur machine, celui-ci se base sur un json injecté au début du fichier par le générateur.
* **tools/templates/template.md.php** --> template d'une page de documentation pour une version Faros en php (avec du markdown).
* **versions_datas/x.json** --> shared.json stocke toutes les informations communes à toutes les versions de faros, chaque fichier *version*.json représente une version individuelle. Voir JSON.
* Le dossier et ses sous-dossiers **docs/generated/** --> contient tous les fichiers générés par le générateur (documentation Markdown & fichiers de tests scripts php).

### le JSON / templates
* Dans le **template markdown** : vous pouvez utiliser du php pour accéder à $versionData.
* Dans le **template php**, pour accéder à une variable du json, accéder à $versionData.
* Dans les **JSON**
    * **pour les requirements**, si l'on souhaite l'afficher mais ne pas le tester, commencer par _.
    * **Pour les settings** (php.ini), possibilité d'ajouter des opérateurs : <= < > >= pour les valeurs chiffrées attendues. Si l'on souhaite faire un commentaire, une ligne simple à afficher directement sur le markdown, et non testée dans la vérification des settings php, donner une clé préfixée par un underscore du type : "_stringunique".

### Ajouter une nouvelle version
* Créer un nouveau fichier json, la version de faros est stockée dans la clé "version", n'hésitez pas à vous baser sur les json existants.
* Penser à modifier l'url dans index.md de la dernière version !
### Modifier une version
* Ouvrez le json et modifiez comme vous le souhaitez les informations. Pour ajouter de nouvelles valeurs et les utiliser voir ci-dessus. En fonction de la complexité des changements il est possible qu'il soit nécessaire de toucher aux templates markdown, php voire même le générateur. Une fois des modifications apportées lancer le générateur (voir ci-dessous) pour actualiser la documentation.


### Execution
```shell
php tools/generator_versions_docs.php [?lienFichierjsonSpécifique]
```
