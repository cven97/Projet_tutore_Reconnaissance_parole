# Voice Command Prediction
Ce projet consiste en un système de prédiction de commandes vocales à partir d'enregistrements audio. L'objectif est de prédire la commande associée à un enregistrement audio donné à l'aide d'un modèle de classification.

## Installation
Assurez-vous d'avoir les bibliothèques suivantes installées :

numpy
keras
os
librosa
soundfile
pydub
datetime
flask
noisereduce
tensorflow
matplotlib
flaskext.mysql
Téléchargez le code source depuis le référentiel GitHub.

Assurez-vous d'avoir un serveur MySQL en cours d'exécution et configurez les informations de connexion dans le fichier app.py.

Placez vos enregistrements audio dans le répertoire Data/DATASET_NEW.

Chargez le modèle pré-entraîné model_entraine.h5 dans le répertoire model.

## Exécutez l'application en utilisant la commande 
**Windows
py app.py.

**Linux
python3 app.py.

## Utilisation
L'application est accessible via une API REST. Vous pouvez envoyer une requête POST à l'URL http://localhost:5000/api/<api_key>/predict pour prédire une commande vocale à partir d'un enregistrement audio.

Assurez-vous d'inclure l'enregistrement audio dans la requête POST en tant que fichier avec la clé audio.

L'API nécessite une clé d'API valide pour authentifier l'utilisateur. Vous pouvez obtenir une clé d'API en vous inscrivant sur le site web du service.

La réponse de l'API sera au format JSON et contiendra les informations suivantes :

status : un booléen indiquant si la prédiction a réussi ou échoué.
mots : le résultat prédit de la commande vocale.
proposition : une liste de propositions pour le choix suivant.

### Contribuer
Les contributions sont les bienvenues ! Si vous souhaitez contribuer à ce projet, veuillez soumettre une demande d'extraction avec vos modifications par mail lompolrnt@gmail.com | hamandea@gmail.com

### Auteurs
Ce projet a été développé par 
    KOURSANGAMA Hamande hamandea@gmail.com
    LOMPO Laurent lompolrnt@gmail.com
