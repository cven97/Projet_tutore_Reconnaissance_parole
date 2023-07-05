# Importation des bibliothèques nécessaires

import librosa
import librosa.display
import os
import pandas as pd
import numpy as np
from sklearn.metrics import *
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
from keras.models import Sequential
from keras.layers import Dense, Dropout, Activation
from keras.utils import np_utils
import soundfile as sf
import noisereduce as nr
import tqdm
from pydub import AudioSegment
import matplotlib.pyplot as plt

# Configuration du chemin d'accès à ffmpeg
os.environ['PATH'] += ';c:/ffmpeg/bin'

# Chemin des répertoires
directory_path = "Data/DATASET_NEW"
modelFolder = 'Model/'

# Définition des fonctions

# Fonction pour récupérer les noms des dossiers
def get_folder_names(directory):
    folder_names = []
    for item in os.listdir(directory):
        if os.path.isdir(os.path.join(directory, item)):
            folder_names.append(item)
    return folder_names

# Appel de la fonction pour récupérer les noms des dossiers
nom_class = get_folder_names(directory_path)

# Fonction pour débruiter un enregistrement audio
def denoise_audio(input_file, output_file, reduction_strength=0.08):
    audio, sr = sf.read(input_file)
    denoised_audio = nr.reduce_noise(audio, sr, reduction_strength)
    sf.write(output_file, denoised_audio, sr)
    print("Enregistrement débruité sauvegardé avec succès!")

# Fonction pour afficher la forme d'onde d'un enregistrement audio
def plot_audio_waveform(file_path):
    audio, sr = librosa.load(file_path)
    plt.figure(figsize=(12, 4))
    librosa.display.waveshow(audio, sr=sr)
    plt.title('Forme d\'onde audio')
    plt.xlabel('Temps (s)')
    plt.ylabel('Amplitude')
    plt.show()

# Fonction pour convertir les fichiers audio en format WAV
def conv_audio_to_wav(name):
    directory = directory_path + '/' + name + '/'
    dirList = os.listdir(directory)
    for file in dirList:
        if file.endswith('.m4a') or file.endswith('.aac'):
            input_file = directory + file
            output_file = directory + os.path.splitext(file)[0] + '.wav'
            try:
                if file.endswith('.aac'):
                    audio = AudioSegment.from_file(input_file, format='aac')
                if file.endswith('.m4a'):
                    audio = AudioSegment.from_file(input_file, format='m4a')
                audio.export(output_file, format='wav')
                print(f"Conversion réussie: {file} -> {os.path.basename(output_file)}")
                os.remove(directory + file)
            except Exception as e:
                print(f"Erreur lors de la conversion de {file}: {str(e)}")

# Fonction pour appliquer un filtre de débruitage sur les chansons
def filtre_song(name):
    directory = directory_path + '/' + name + '/'
    dirList = os.listdir(directory)
    i = 1
    for file in dirList:
        input_file = directory + file
        output_file = directory + name + "_" + str(i) + '.wav'
        try:
            denoise_audio(input_file, output_file, reduction_strength=0.05)
            os.remove(directory + file)
            i = i + 1
        except Exception as e:
            print(f"Erreur lors de la conversion de {file}: {str(e)}")

# Fonction pour couper un enregistrement audio
def cut_audio(file_path, output_file_path, duration):
    audio, sr = sf.read(file_path)
    sf.write(output_file_path, audio, sr)
    print("Enregistrement coupé avec succès!")

# Fonction pour couper les chansons
def cut_song(name):
    directory = directory_path + '/' + name + '/'
    dirList = os.listdir(directory)
    i = 1
    for file in dirList:
        input_file = directory + file
        for j in range(1, 11):
            output_file = directory + name + "_" + str(j) + "_" + str(i) + '.wav'
            try:
                cut_audio(input_file, output_file, duration=0.05)
                i = i + 1
            except Exception as e:
                print(f"Erreur lors de la coupure de {file}: {str(e)}")

# Conversion des fichiers audio en format WAV
def conv_dataset(name_list):
    for name in name_list:
        conv_audio_to_wav(name)

# Application du filtre de débruitage sur les chansons
def filtre_dataset(name_list):
    for name in name_list:
        filtre_song(name)

# Coupe des chansons en segments plus courts
def cut_dataset(name_list):
    for name in name_list:
        cut_song(name)

# Fonction pour récupérer le DataFrame contenant les données
def get_df(name_list):
    print("Chargement du Dataset...")
    df_final = pd.DataFrame(columns=['Seq', 'Name'])
    for name in tqdm.tqdm(name_list, desc="Processing classes"):
        nb_files = len(os.listdir(directory_path + '/' + name + '/'))
        colList = ['Seq', 'Name']
        d = {}
        for i in colList:
            d[i] = range(nb_files)
        df = pd.DataFrame(d, columns=colList)
        df = df.astype('object')
        df = extract(name, df)
        df_final = pd.concat([df_final, df], axis=0)
    return df_final

# Fonction pour extraire les caractéristiques audio MFCC
def extract(name, df):
    directory = directory_path + '/' + name + '/'
    dirList = os.listdir(directory)
    z = 0
    for file in dirList:
        data, sampling_rate = librosa.load(directory + file, res_type='kaiser_fast')
        mfccs = np.mean(librosa.feature.mfcc(y=data, sr=sampling_rate, n_mfcc=40).T, axis=0)
        df.iloc[z, 0] = mfccs
        df.iloc[z, 1] = name
        z += 1
    return df

# Appel de la fonction pour récupérer le DataFrame contenant les données audio et les étiquettes
df = get_df(nom_class)

# Conversion des colonnes 'Seq' et 'Name' du DataFrame en tableaux numpy
X = np.array(df.Seq.tolist())  # Caractéristiques audio (MFCC)
y = np.array(df.Name.tolist())  # Étiquettes correspondantes

# Encodage des étiquettes en utilisant LabelEncoder et one-hot encoding
lb = LabelEncoder()
y = np_utils.to_categorical(lb.fit_transform(y))

# Détermination du nombre de classes (nombre d'étiquettes)
num_labels = y.shape[1]

# Séparation des données en ensembles d'entraînement et de test
X_train, X_test, y_train, y_test = train_test_split(X, y, train_size=0.8, random_state=42)


# Création du modèle
model = Sequential()

# Ajout d'une couche Dense avec 1024 neurones et une forme d'entrée de (40,)
model.add(Dense(1024, input_shape=(40,)))
model.add(Activation('relu'))  
model.add(Dropout(0.1))  

# Ajout d'une autre couche Dense avec 1024 neurones
model.add(Dense(1024))
model.add(Activation('relu')) 
model.add(Dropout(0.3)) 

# Ajout de deux autres couches Dense avec 1024 neurones chacune
model.add(Dense(1024))
model.add(Activation('relu')) 
model.add(Dropout(0.1)) 

# Ajout de deux autres couches Dense avec 1024 neurones chacune
model.add(Dense(1024))
model.add(Activation('relu')) 
model.add(Dropout(0.3)) 

# Ajout d'une dernière couche Dense avec le nombre d'étiquettes (classes) en sortie
model.add(Dense(num_labels))
model.add(Activation('softmax'))  # Fonction d'activation softmax pour la classification

# Compilation du modèle avec la fonction de perte 'categorical_crossentropy',
# la métrique d'évaluation 'accuracy' et l'optimiseur 'adam'
model.compile(loss='categorical_crossentropy', metrics=['accuracy'], optimizer='adam')

# Affichage du résumé du modèle
model.summary()

# Evaluation du modele avant entrainement

loss, acc = model.evaluate(X_test, y_test)
print("Test Loss", loss)
print("Test Accuracy", acc)

# Entraînement du modèle

# Entraînement du modèle avec les données d'entraînement (X_train, y_train)
# Utilisation d'une taille de lot (batch_size) de 64, 30 époques (epochs) et validation sur les données de test (X_test, y_test)
history = model.fit(X_train, y_train, batch_size=64, epochs=30, validation_data=(X_test, y_test))

# Fin de l'entraînement du modèle

# Obtention des métriques d'entraînement
metrics = history.history

# Affichage de la courbe d'apprentissage (loss et val_loss)
plt.plot(history.epoch, metrics['loss'], metrics['val_loss'])
plt.legend(['loss', 'val_loss'])
plt.show()

# Evaluation du modele après entrainement

loss, acc = model.evaluate(X_test, y_test)
print("Test Loss", loss)
print("Test Accuracy", acc)


# Test du modèle sur un audio lumiere

input_file = 'Data/test/test_lumiere.wav'

# Extraire les caractéristiques audio
data, sampling_rate = librosa.load(input_file, res_type='kaiser_fast')
mfccs = np.mean(librosa.feature.mfcc(y=data, sr=sampling_rate, n_mfcc=40).T, axis=0)
X = np.array([mfccs])

# Faire la prédiction
model_output = model.predict(X)
prediction = np.unravel_index(model_output.argmax(), model_output.shape)[1]

# Résultat
print("Commande audio predit", nom_class[prediction])
print("Commande audio origine :", "Lumière")

# Sauvegarde du modèle entraîné au format H5
model.save(modelFolder + 'model_entraine.h5')


