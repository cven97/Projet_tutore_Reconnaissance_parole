# Importation des bibliothèques nécessaires
import numpy as np
from keras.models import load_model
import os
import librosa
import soundfile as sf
from pydub import AudioSegment
from datetime import datetime
from flask import Flask, request, jsonify, make_response
import noisereduce as nr
import tensorflow as tf
import matplotlib.pyplot as plt
from flaskext.mysql import MySQL

# Définition du répertoire contenant les données
directory_path = "Data/DATASET_NEW"

# Récupérer les noms des dossiers dans le répertoire donné
def get_folder_names(directory):
    folder_names = []
    for item in os.listdir(directory):
        if os.path.isdir(os.path.join(directory, item)):
            folder_names.append(item)
    return folder_names

# Obtenir la date et l'heure actuelles sous forme de chaîne de caractères
def get_datetime():
    now = datetime.now()
    
    year = str(now.year)
    month = str(now.month).zfill(2)
    day = str(now.day).zfill(2)
    hours = str(now.hour).zfill(2)
    minutes = str(now.minute).zfill(2)
    seconds = str(now.second).zfill(2)
    
    datetime_string = f"_{year}_{month}_{day}_{hours}_{minutes}_{seconds}"
    
    return datetime_string

def denoise_audio(input_file, output_file, reduction_strength=0.5):
    # Charger l'enregistrement audio
    audio, sr = sf.read(input_file)

    # Réduction du bruit
    denoised_audio = nr.reduce_noise(audio, sr, reduction_strength)

    # Sauvegarder le fichier audio débruité
    os.remove(input_file)
    sf.write(output_file, denoised_audio, sr)

    print("Enregistrement débruité avec succès!")

def cut_audio(file_path, output_file_path, duration):
    # Charger l'enregistrement audio
    audio, sr = sf.read(file_path)

    # Calculer le nombre d'échantillons à conserver
    samples_to_keep = int(sr * duration)

    # Couper les derniers échantillons
    cut_audio = audio[samples_to_keep:]

    # Sauvegarder le fichier audio coupé
    os.remove(file_path)
    sf.write(output_file_path, cut_audio, sr)

    print("Enregistrement coupé avec succès!")

#Tracer le graphe d'un audio
def plot_audio_waveform(file_path):
    # Charger l'enregistrement audio
    audio, sr = librosa.load(file_path)
    
    # Afficher la forme d'onde
    plt.figure(figsize=(12, 4))
    librosa.display.waveshow(audio, sr=sr)
    plt.title('Forme d\'onde audio')
    plt.xlabel('Temps (s)')
    plt.ylabel('Amplitude')
    plt.show()

#Donnée regroupré pour predire la commande suivante
donnees = {
    'etat1': [['active', 'allume', 'arrêt', 'désactiver', 'etat', 'éteint'], ['camera', 'lecteur', 'lecteur', 'télévision', 'lumière', 'climatisation', 'ventilateur', 'cuisinière', 'cuisine', 'gazinière', 'réfrigérateur', 'radio'], ['Salon', 'terrasse', 'balcon', 'chambre']],
    'etat2': [['augmente', 'diminue'], ['volume', 'vitesse', 'chauffage', 'température']],
    'etat3': [['ouvre', 'ferme'], ['rideaux', 'fenêtre', 'porte', 'portail']],
    'etat4': [['passe', 'précédent', 'suivant', 'change'], ['chaîne', 'musique', 'piste', 'radio']],
    'etat5': [['chaîne'], ['radio', 'télévision'], ['passe', 'précédent', 'suivant', 'change']],
}
#Fonction de prediction du choix suivant
def verifier_choix(choix, etape=1):
    res_correspondante = []
    for suivant, reponses in donnees.items():
        if choix in reponses[etape - 1]:
            res_correspondante = reponses[etape]
            return res_correspondante
    return res_correspondante

current_datetime_string = get_datetime()

# Appel de la fonction pour récupérer les noms des dossiers
nameList = get_folder_names(directory_path)

# crée une instance de l'application Flask
app = Flask(__name__)

# Configuration de la base de données MySQL
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = ''
app.config['MYSQL_DATABASE_DB'] = 'intellihouse'
app.config['MYSQL_DATABASE_HOST'] = 'localhost'

mysql = MySQL(app)

# Configuration du répertoire de sauvegarde des fichiers audios recus
app.config['UPLOAD_FOLDER'] = 'file'

# Charger le modèle entraîné
model = load_model('Model/model8.h5') 


@app.route('/api/<api_key>/predict', methods=['POST'])
def predict(api_key):
    # Verification de la clé "api_key"

    cursor = mysql.get_db().cursor()
    cursor.execute('SELECT id, nbr_commande FROM users WHERE token = %s', (api_key,))
    data = cursor.fetchall()
    id = 0
    for row in data:
        id = row[0]
        nbr_commande = int(row[1])

    print(id, nbr_commande)

    #Renvoie un status false si la cle ne correspond pas a celui d'un utilisateur de la base de données
    if id == 0 :
        response = {
                'status': False,
                'mots': "",
                'proposition': [],
                'Description': "Clé de l'API Invalide"
            }
        response = make_response(response)
        response.headers.add('Access-Control-Allow-Origin', '*')

        return response
    
    # Mise a jour du compteur de comande vocal

    nbr_commande += 1
    cursor.execute('UPDATE users SET nbr_commande = %s WHERE id = %s', (nbr_commande, int(id),))
    
    # Vérifier si un fichier audio a été envoyé dans la requête

    if 'audio' not in request.files:
        return jsonify(error='Aucun fichier audio n\'a été envoyé.')

    audio_file = request.files['audio']
 
    # Sauvegarder le fichier audio dans le répertoire de sauvegarde
    filename = audio_file.filename
    save_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
    audio_file

    
    # Convertir le fichier audio en WAV
    wav_path = os.path.join(app.config['UPLOAD_FOLDER'], 'audio'+get_datetime()+'.wav')
    audio = AudioSegment.from_file(save_path)
    audio = audio.set_sample_width(2)  # 2 bytes = 16 bits
    audio.export(wav_path, format='wav')
    os.remove(save_path)

    denoise_audio(wav_path,wav_path)
    cut_audio(wav_path,wav_path, duration=0.1)
 
    # Extraire les caractéristiques audio
    data, sampling_rate = librosa.load(wav_path, res_type='kaiser_fast')
    mfccs = np.mean(librosa.feature.mfcc(y=data, sr=sampling_rate, n_mfcc=40).T, axis=0)
    X = np.array([mfccs])

    # prédiction sur l'audio

    predictions = model.predict(X)
    
    # Obtenir l'index de la classe prédite
    predicted_class = np.argmax(predictions)

    # Renvoyer la prédiction sous forme de réponse JSON

    response = {
                'status': True,
                'mots': nameList[predicted_class],
                'proposition': verifier_choix(nameList[predicted_class])
            }
    
    response = make_response(response)
    response.headers.add('Access-Control-Allow-Origin', '*')

    return response

if __name__ == '__main__':
    app.run(debug=True)


