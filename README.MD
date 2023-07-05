# Reconnaissance de parole

Ce projet de master de l'Université Joseph KI-ZERBO de Ouagadougou vise à reconnaître la parole à partir d'enregistrements audio. L'objectif principal est de développer un modèle d'apprentissage automatique capable de prédire les commandes vocales associées à des enregistrements audio donnés.

## Reconnaissance de parole (Première partie du projet)

La première partie du projet se concentre sur la reconnaissance de parole. Elle comprend plusieurs étapes cruciales :

1. Prétraitement des données audio : Les fichiers audio sont prétraités pour améliorer leur qualité et faciliter l'analyse ultérieure. Cela implique la conversion des fichiers audio dans un format standardisé, tel que le format WAV, l'application de techniques de réduction de bruit pour éliminer les perturbations indésirables, et la découpe des chansons en segments plus courts pour faciliter le traitement.

2. Construction du modèle : Un modèle d'apprentissage automatique est construit pour la reconnaissance de parole. Dans ce projet, nous utilisons un réseau de neurones à plusieurs couches pour capturer les caractéristiques acoustiques des enregistrements audio et prédire les commandes vocales associées. La construction du modèle comprend la définition de l'architecture du réseau, l'initialisation des poids et des biais, et l'optimisation des paramètres du modèle pour obtenir de bonnes performances de prédiction.

3. Entraînement du modèle : Le modèle est entraîné sur un ensemble de données préalablement étiquetées. Pendant le processus d'entraînement, le modèle ajuste ses poids et biais pour minimiser l'erreur de prédiction. L'objectif est d'obtenir un modèle capable de généraliser et de prédire avec précision les commandes vocales pour de nouveaux enregistrements audio.

## API Projet de Reconnaissance Vocale (Deuxième partie du projet)

La deuxième partie du projet consiste à développer une API pour la reconnaissance vocale. L'API permettra aux utilisateurs d'envoyer des enregistrements audio et de recevoir les prédictions des commandes vocales associées. Voici les étapes clés de cette partie :

1. Installation des dépendances : Avant d'exécuter l'API, il est nécessaire d'installer les dépendances requises, telles que les bibliothèques Python pour le traitement audio (comme librosa et soundfile), le deep learning (comme TensorFlow et Keras), et le framework de développement web Flask.

2. Configuration de l'API : L'API est configurée pour écouter les requêtes HTTP des clients et y répondre. Cela implique la définition des routes et des points d'entrée pour les différentes fonctionnalités de l'API.

3. Utilisation de l'API : Les utilisateurs peuvent envoyer des enregistrements audio à l'API en utilisant une requête POST avec une clé d'API valide. L'API utilise le modèle de reconnaissance de parole entraîné précédemment pour prédire les commandes vocales associées à l'enregistrement audio. Les prédictions sont renvoyées aux utilisateurs sous forme de réponse JSON.

## Application IntelliHouse (Troisième partie du projet)

La troisièmepartie du projet concerne la création d'une application pratique appelée IntelliHouse. Cette application met en œuvre la reconnaissance de parole développée précédemment dans un contexte spécifique, à savoir le contrôle vocal d'une maison intelligente.

L'application IntelliHouse permet aux utilisateurs de contrôler divers dispositifs domestiques en utilisant des commandes vocales. Elle offre une interface intuitive et conviviale qui facilite l'interaction avec les différents équipements de la maison. Voici les principales fonctionnalités de l'application :

1. Configuration des dispositifs : L'application permet aux utilisateurs de configurer les différents dispositifs présents dans leur maison intelligente. Ils peuvent ajouter des dispositifs tels que des ampoules, des televisions, des caméras de sécurité, des climatiseurs, etc. Cette fonctionnalité permet à l'application de reconnaître les dispositifs disponibles pour les commandes vocales ultérieures.

2. Association des commandes vocales : Les utilisateurs peuvent associer des commandes vocales spécifiques à chaque dispositif. Par exemple, ils peuvent prononcer la commande "Allume la lumière du salon" pour allumer l'ampoule du salon. Cela permet à l'application de comprendre les intentions des utilisateurs lorsqu'ils donnent des commandes vocales.

3. Contrôle des dispositifs : Une fois les commandes vocales reconnues, l'application mets à jour les le status appropriées aux dispositifs correspondants dans une base de données. Par exemple, si l'utilisateur envoie la commande "Allume la lumière du salon", l'application enverra une instruction pour mettre à jour le status de l'ampoule du salon a allumé. Cela permet aux utilisateurs de contrôler leur maison intelligente de manière pratique et sans effort.

4. Interface utilisateur conviviale : IntelliHouse dispose d'une interface utilisateur attrayante et facile à utiliser. Les utilisateurs peuvent interagir avec les dispositifs à l'aide d'options de commande vocale prédéfinies ou en utilisant des commandes personnalisées. L'interface est conçue de manière à offrir une expérience utilisateur fluide et intuitive.

L'application IntelliHouse représente une mise en pratique concrète du modèle de reconnaissance de parole développé dans le cadre du projet de master. Elle offre une expérience utilisateur immersive en permettant le contrôle vocal des dispositifs d'une maison intelligente.

Les auteurs de ce projet de master, KOURSANGAMA Hamande (hamandea@gmail.com) et LOMPO Laurent (lompolrnt@gmail.com), ont développé l'application IntelliHouse dans le but d'explorer les applications pratiques de la reconnaissance de parole et de faciliter l'interaction homme-machine dans un environnement domestique.

Pour plus d'informations ou pour toute question, veuillez contacter les auteurs du projet aux adresses e-mail mentionnées ci-dessus.
