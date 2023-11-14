# Générateur de documentation & scripts FAROS VERSION help

### Les fichiers
* **tools/generator_versions_docs.php** --> le script php à déclencher, qui se base sur les fichiers json basé dans le dossier /versions_data et les templates /templates  
* **tools/templates/check_version_script_template.php** --> le template du script PHP offert aux hébergeurs afin de tester leur machine, celui-ci se base sur un json injecté au début du fichier par le générateur.
* **tools/templates/template.md.php** --> template d'une page de documentation pour une version Faros en php (avec du markdown) - php éxécuté par le générateur qui lui donne en argv le lien du json, lu dans le fichier et utilisé pour compléter le template. Son execution finie, ce que renvoie php (le fichier rempli) est redirigé dans le fichier markdown final depuis le générateur.
* **versions_datas/x.json** --> shared.json stock toutes les informations communes à toutes les versions de faros, chaque fichier *version*.json représente une version individuelle. Voir JSON.
ce dossier et ses sous-dossiers **docs/generated/** --> tous les fichiers générés par le générateur sont situés dans  (documentation Markdown & fichiers de tests scripts php).
### le JSON / templates
* Dans le **template markdown** : vous pouvez utiliser du php pour accéder à $versionData.
* Dans le **template php**, pour accéder à une variable du json, accéder à $versionData.
* Dans les **JSON**
	* **pour les requirements**, si l'on souhaite l'afficher mais ne pas le tester, commencer par _. 
	* **Pour les settings** (php.ini), possibilité d'ajouter des opérateurs : <= < > >= pour les valeurs chiffrées attendues. Si l'on souhaite faire un commentaire, une ligne simple à afficher textuelle sur le markdown, et non testé dans la vérification des settings php , donner une clé style : "_stringunique".

### Ajouter une nouvelle version
* Créer un nouveau fichier json, la version de faros est stockée dans la clée "version", n'hésitez pas à vous baser sur les json existants.
* Penser à modifier l'url dans index.md de la dernière version ! 
### Modifier une version
* Ouvrez le json et modifiez comme vous le souhaitez les informations. Pour ajouter de nouvelles valeurs et les utiliser voir ci-dessus. En fonction de la complexité des changements il est possible qu'il soit nécessaire de toucher aux templates markdown, php voire même le générateur. Une fois des modifications apportées lancer le générateur (Voir ci-dessous) pour actualiser la documentation. 


### Execution
`php generator_versions_docs.php [?lienFichierjsonSpécifique]`
