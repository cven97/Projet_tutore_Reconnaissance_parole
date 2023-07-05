####################### Reconnaissance de parole ###########################

Ce projet vise à développer un modèle d'apprentissage automatique pour la Reconnaissance de parole. Le code fourni vous permet de prétraiter les données audio, de construire le modèle et de l'entraîner pour prédire les classes des sons.

Dépendances

Le code est écrit en Python et utilise les bibliothèques suivantes :
    librosa
    pandas
    numpy
    scikit-learn
    Keras
    soundfile
    noisereduce
    tqdm
    pydub
    matplotlib

Assurez-vous d'installer ces bibliothèques avant d'exécuter le code.

Structure des Répertoires
Assurez-vous d'organiser vos données audio selon la structure suivante :

markdown
Copy code
- Data/
  - DATASET/
    - Class1/
      - sound1.wav
      - sound2.wav
      ...
    - Class2/
      - sound1.wav
      - sound2.wav
      ...
    ...

Le dossier Data contient le répertoire DATASET qui contient les sous-répertoires pour chaque classe de sons. Chaque classe contient les fichiers audio correspondants.

********* Prétraitement des Données
Avant de construire et d'entraîner le modèle, vous pouvez effectuer les étapes suivantes de prétraitement des données :

    Conversion des fichiers audio en format WAV : Utilisez la fonction conv_dataset(name_list) pour convertir les fichiers audio en format WAV. Assurez-vous d'ajouter les noms des classes dans la liste name_list dans le code.

    Débruitage des enregistrements audio : Utilisez la fonction filtre_dataset(name_list) pour appliquer un filtre de débruitage sur les chansons. Assurez-vous d'ajouter les noms des classes dans la liste name_list dans le code.

    Coupe des chansons en segments plus courts : Utilisez la fonction cut_dataset(name_list) pour couper les chansons en segments plus courts. Assurez-vous d'ajouter les noms des classes dans la liste name_list dans le code.

********* Construction du Modèle
Le modèle utilisé est un réseau de neurones à plusieurs couches. Voici l'architecture du modèle :

_________________________________________________________________
Layer (type)                 Output Shape              Param #
=================================================================
dense (Dense)                (None, 1024)              41984
_________________________________________________________________
activation (Activation)      (None, 1024)              0
_________________________________________________________________
dropout (Dropout)            (None, 1024)              0
_________________________________________________________________
dense_1 (Dense)              (None, 1024)              1049600
_________________________________________________________________
activation_1 (Activation)    (None, 1024)              0
_________________________________________________________________
dropout_1 (Dropout)          (None, 1024)              0
_________________________________________________________________
dense_2 (Dense)              (None, 1024)              1049600
_________________________________________________________________
activation_2 (Activation)    (None, 1024)              0
_________________________________________________________________
dropout_2 (Dropout)          (None, 1024)              0
_________________________________________________________________
dense_3 (Dense)              (None, 1024)              1049600
_________________________________________________________________
activation_3 (Activation)    (None, 1024## Entraînement du Modèle)


********* Entraînement du Modèle
Une fois que les données ont été prétraitées et que le modèle a été construit, vous pouvez procéder à l'entraînement du modèle en utilisant les étapes suivantes :

    Séparation des données en ensembles d'entraînement et de test : Les données sont divisées en ensembles d'entraînement et de test à l'aide de la fonction train_test_split. Par défaut, 80% des données sont utilisées pour l'entraînement et 20% pour les tests. Vous pouvez ajuster ce ratio selon vos besoins.

    Encodage des étiquettes : Les étiquettes des classes sont encodées à l'aide de LabelEncoder et du codage one-hot à l'aide de np_utils.to_categorical.

    Compilation du modèle : Le modèle est compilé en spécifiant la fonction de perte (categorical_crossentropy), la métrique d'évaluation (accuracy) et l'optimiseur (adam).

    Entraînement du modèle : Le modèle est entraîné en utilisant les données d'entraînement. Vous pouvez ajuster les paramètres tels que la taille du lot (batch_size), le nombre d'époques (epochs) et les données de validation (validation_data).

    Évaluation du modèle : Une fois l'entraînement terminé, le modèle est évalué sur les données de test pour obtenir la perte (loss) et l'exactitude (accuracy) du modèle.

    Visualisation des Résultats
    Après l'entraînement du modèle, vous pouvez visualiser les résultats à l'aide des graphiques suivants :

    Courbe d'apprentissage : La courbe de perte (loss) et de perte de validation (val_loss) est tracée pour visualiser la performance du modèle pendant l'entraînement.

    Courbe d'exactitude : La courbe d'exactitude (accuracy) et d'exactitude de validation (val_accuracy) est tracée pour visualiser l'amélioration de l'exactitude du modèle pendant l'entraînement.

Contribuer
Les contributions sont les bienvenues ! Si vous souhaitez contribuer à ce projet, veuillez soumettre une demande d'extraction avec vos modifications par mail lompolrnt@gmail.com | hamandea@gmail.com

Auteurs
Ce projet a été développé par 
    KOURSANGAMA Hamande hamandea@gmail.com
    LOMPO Laurent lompolrnt@gmail.com
    
Conclusion

Ce README décrit les étapes pour utiliser le code fourni pour la Reconnaissance de mots en utilisant un modèle d'apprentissage automatique. Assurez-vous de prétraiter les données audio correctement et d'ajuster les paramètres du modèle selon vos besoins. N'hésitez pas à explorer d'autres architectures de modèle et techniques de prétraitement pour améliorer les performances de classification des sons.