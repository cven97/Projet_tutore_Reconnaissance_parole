@extends('layout.app')

@section('titre')
    Commande
@endsection

@section('main')
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Content Start -->
    <div class="content-fluid">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
            <img class="" src="img/logo2.png " style="height: 80px;margin-right: 5px" alt="">
            <h3 class="text-primary">IntelliHouse</h3>
            <div class="navbar-nav align-items-center ms-auto">
                <div class="nav-item dropdown">

                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="img/user.png" alt=""
                            style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex">{{$user->nom ." ".$user->prenom}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">Deconnexion</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->


        <div class="container-fluid pt-4 px-4 d-flex align-items-center justify-content-center">
            <div class="row g-4 col-md-8">
                <div class=" col-sm-12" style="height: 380px;">
                    <div class="bg-secondary rounded p-4 text-center">
                        <h2 class="mb-4">Lancer une commande vocale</h2>
                        <h4 class="mb-4 text-success" id="msg">...</h4>
                        <h4 class="mb-4" id="msg_erreur" style="display: none;">
                            <p class="text-primary">Impossible de contacter le serveur <br>veuillez recommencer...
                            </p>
                        </h4>

                    </div>

                    <div class="bg-secondary rounded h-100 p-2">
                        <h6 class="mb-2">Essayer :</h6>
                        <ul class="row list-proposition">
                            <li class="bg-transparent col-md-3" style="list-style: none;">Activer</li>
                            <li class="bg-transparent col-md-3" style="list-style: none;">Lumiere</li>
                            <li class="bg-transparent col-md-3" style="list-style: none;">Radio</li>
                            <li class="bg-transparent col-md-3" style="list-style: none;">Climatisation</li>
                            <li class="bg-transparent col-md-3" style="list-style: none;">Réfrigerateur</li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-12 ">
                    <div class="bg-secondary rounded p-4 d-flex justify-content-center align-items-center">
                        <button id="startButton" class="btn btn-lg btn-success btn-lg-square btn-3d"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-mic" style="font-size: 50px;"></i>
                        </button>

                        <button id="stopButton" class="btn btn-lg btn-primary btn-lg-square btn-3d"
                            style="width: 100px; height: 100px; display: none;">
                            <i class="bi bi-mic" style="font-size: 50px;"></i>
                            <span class="wave"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none" id="token" token="{{$user->token}}"></div>


    </div>
@endsection

@section('script')
    <script>
        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');
        let mediaRecorder;
        let chunks = [];
        let commande = "";

        function getCurrentDateTimeString() {
            var now = new Date();

            var year = now.getFullYear();
            var month = String(now.getMonth() + 1).padStart(2, '0');
            var day = String(now.getDate()).padStart(2, '0');
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var seconds = String(now.getSeconds()).padStart(2, '0');

            var dateTimeString = year + '_' + month + '_' + day + '_' + hours + '_' + minutes + '_' + seconds;

            return dateTimeString;
        }



        startButton.addEventListener('click', function() {

            document.getElementById('msg_erreur').style.display = 'none';
            document.getElementById('msg').style.display = 'block';

            navigator.mediaDevices.getUserMedia({
                    audio: true
                })
                .then(function(stream) {

                    document.getElementById('startButton').style.display = 'none';
                    document.getElementById('stopButton').style.display = 'block';
                    mediaRecorder = new MediaRecorder(stream);

                    mediaRecorder.addEventListener('dataavailable', function(event) {
                        chunks.push(event.data);
                    });

                    mediaRecorder.start();
                })
                .catch(function(error) {
                    console.error('Erreur lors de l\'accès au microphone:', error);
                    startButton.disabled = false;
                    stopButton.disabled = true;
                });
        });

        stopButton.addEventListener('click', function() {
            document.getElementById('startButton').style.display = 'block';
            document.getElementById('stopButton').style.display = 'none';

            mediaRecorder.stop();

            mediaRecorder.addEventListener('stop', function() {
                const audioBlob = new Blob(chunks, {
                    type: 'audio/webm'
                });
                const audioURL = URL.createObjectURL(audioBlob);

                // Envoyer l'enregistrement
                uploadRecording();

                chunks = [];
            });
        });


        function uploadRecording() {

            var msg = document.getElementById('msg');
            msg.innerHTML = commande + "...";

            if (chunks.length === 0) {
                console.warn('Aucun enregistrement à envoyer.');
                return;
            }

            const blob = new Blob(chunks, {
                type: 'audio/mp3'
            });

            token = document.getElementById('token')
            val_token = token.getAttribute("token")

            const formData = new FormData();
            formData.append('audio', blob, 'enregistrement-' + getCurrentDateTimeString() + '.mp3');
            chunks = [];
            fetch('http://127.0.0.1:5000/api/'+val_token+'/predict', {
                method: 'POST',
                body: formData
            }).then(function(response) {
                if (!response.ok) {

                    document.getElementById('msg_erreur').style.display = 'block';
                    document.getElementById('msg').style.display = 'none';
                    throw new Error('Erreur lors de l\'envoi de l\'enregistrement audio à l\'API.');
                }

                document.getElementById('msg_erreur').style.display = 'none';
                document.getElementById('msg').style.display = 'block';
                return response.json(); // Convertir la réponse en JSON



            }).then(function(data) {
                // Récupérer la valeur de response.mots
                var mots = data.mots;

                console.log('Mots prédits :', mots);
                var msg = document.getElementById('msg');
                commande = commande + " " + mots
                msg.innerHTML = commande;
                if(data.proposition)
                    ajouterListe(data.proposition)


                // Cacher le bouton "Envoyer l'enregistrement" et revenir à l'état "Enregistrer"
                document.getElementById('startButton').style.display = 'block';
            }).catch(function(error) {
                document.getElementById('msg_erreur').style.display = 'block';
                document.getElementById('msg').style.display = 'none';

                console.error('Erreur lors de l\'envoi de l\'enregistrement audio à l\'API:', error);
            });
        }

        function ajouterListe(proposition) {
            var ulElement = document.querySelector('.list-proposition');
            ulElement.innerHTML = ""
            for (var i = 0; i < proposition.length; i++) {
                var liElement = document.createElement('li');
                liElement.classList.add('bg-transparent', 'col-md-3');
                liElement.textContent = proposition[i];
                liElement.style.listStyle = 'none';
                ulElement.appendChild(liElement);
            }
        }
    </script>
@endsection
