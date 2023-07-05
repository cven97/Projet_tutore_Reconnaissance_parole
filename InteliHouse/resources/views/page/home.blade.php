@extends('layout.app')

@section('titre')
    Home
@endsection

@section('main')
    <div class="container-fluid ">
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
                            <span class="d-none d-lg-inline-flex">{{ $user->nom . ' ' . $user->prenom }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">Deconexion</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            @if (Session::has('success_msg'))
                <div class="d-flex justify-content-end mt-4">
                    <div class="col-4 alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><span>{{ Session::get('success_msg') }} </span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @if (Session::has('error_msg'))
                <div class=" d-flex justify-content-end mt-4">
                    <div class="col-4 alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><span>{{ Session::get('error_msg') }} </span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-2 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa bi-mic fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Commande vocal</p>
                                <h6 class="mb-0">{{$user->nbr_commande}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-solid fa-bolt fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Appareil</p>
                                <h6 class="mb-0">{{$data[0]}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-solid fa-lightbulb fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Appareil Actif</p>
                                <h6 class="mb-0">{{$data[1]}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-thin fa-lightbulb fa-3x"></i>
                            <div class="ms-3">
                                <p class="mb-2">Appareil etein</p>
                                <h6 class="mb-0">{{$data[0] - $data[1]}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-sm-12 col-xl-6 ">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Profile</h6>
                            <div class="col-12 owl-carousel testimonial-carousel owl-loaded owl-drag">
                                <div class="owl-stage-outer">
                                    <div class="owl-stage">
                                        <div class="col-12 owl-item cloned">
                                            <div class="col-12 testimonial-item text-center">
                                                <img class="img-fluid rounded-circle mx-auto mb-4" src="img/user.png"
                                                    style="width: 100px; height: 100px;">
                                                <h5 class="mb-1">{{ $user->nom . ' ' . $user->prenom }}</h5>
                                                <p>{{ $user->email }}</p>

                                                <a class="btn btn-primary w-50 m-2" href="{{ route('vocal') }}" type="button">Demarer
                                                    commande vocale</a>

                                                <p class="mb-0">Vivez l'avenir de la maison intelligente</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Ajouter un piece</h6>
                            <form action="{{ route('piece_ajout') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" required>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary">Ajouter</button>
                            </form>

                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="pt-4 px-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-xl-6">
                                <div class="bg-secondary rounded h-100 p-4">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="mb-4">Liste de vos pieces</h4>

                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Piece</th>
                                                <th scope="col">action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($i = 1)
                                            @foreach ($user->pieces as $item)
                                                <tr>
                                                    <th scope="row">{{ $i }}</th>
                                                    <td>{{ $item->libelle }}</td>
                                                    <td>
                                                        <a style="cursor: pointer"
                                                            onclick="charger_appareil({{ $item->id }});">
                                                            <i class="fa fa-eye fa-1x text-primary"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php($i++)
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-6">
                                <div class="bg-secondary rounded h-100 p-4">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="mb-4">Liste de vos appareils <span class="text-primary"
                                                id="nom_piece"></span></h4>
                                        <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            data-bs-whatever="@getbootstrap">
                                            <i class="fa fa-plus fa-2x text-primary" id="add_app_disp"
                                                style="cursor: pointer; display: none"></i>
                                        </a>


                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-titl " style="color: black"
                                                            id="exapleModalLabel">
                                                            Choisissez un appareil
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="mb-3">
                                                                <label for="recipient-name"
                                                                    class="col-form-label">Appareil</label>
                                                                <select
                                                                    class="form-select form-select-lg mb-3 bg-white text-black"
                                                                    aria-label=".form-select-lg example"
                                                                    style="color: black" id="select_app">
                                                                    @foreach ($appareils as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->nom }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fermer</button>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="post_appareil()">Enregistrer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <table class="table app_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Appareil</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container-fluid pt-4 px-4">

                <!-- Footer Start -->
                <div class="container-fluid pt-4 px-4">
                    <div class="bg-secondary rounded-top p-4">
                        <div class="row">
                            <div class="col-12 col-sm-6 text-center text-sm-start">
                                &copy; <a href="#">IntelliHouse</a>, All Right Reserved.
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Footer End -->
            </div>
            <!-- Content End -->


            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>
    @endsection

    @section('script')
        <script>
            var id_piece = 0;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');



            function charger_appareil(id) {
                // Appeler l'API pour récupérer la liste des appareils
                id_piece = id
                console.log(id)
                fetch('/liste-appareil/' + id)
                    .then(response => response.json())
                    .then(data => {
                        // Récupérer l'élément table dans le HTML
                        const table = document.querySelector('.app_table');
                        table.innerHTML = '';


                        const spanElement = document.querySelector('#nom_piece');
                        spanElement.textContent = data[0].libelle;
                        const add_app_disp = document.querySelector('#add_app_disp')
                        add_app_disp.style.display = 'block';


                        // Créer l'en-tête de la table
                        const thead = document.createElement('thead');
                        const headerRow = document.createElement('tr');
                        const headers = ['#', 'Appareil', 'Status', 'Action'];

                        headers.forEach(headerText => {
                            const th = document.createElement('th');
                            th.setAttribute('scope', 'col');
                            th.textContent = headerText;
                            headerRow.appendChild(th);
                        });

                        thead.appendChild(headerRow);
                        table.appendChild(thead);

                        // Créer le corps de la table
                        const tbody = document.createElement('tbody');
                        data[1].forEach((device, index) => {
                            const row = document.createElement('tr');
                            const deviceNumberCell = document.createElement('th');
                            deviceNumberCell.setAttribute('scope', 'row');
                            deviceNumberCell.textContent = index + 1;

                            const deviceNameCell = document.createElement('td');
                            deviceNameCell.textContent = device.nom;

                            const span = document.createElement('span');

                            text = device.status == 0 ? "étient" : "Allumé";
                            style = device.status == 0 ? "text-primary" : "text-success";
                            span.textContent = text
                            span.setAttribute('class', style);


                            const action = document.createElement('i');
                            action.setAttribute('class', "fa fa-edit fa-1x text-primary");
                            action.setAttribute('style', "cursor: pointer;");
                            action.setAttribute('onclick', "modifierStatutAppareil(" + device.id + ", "+id+")");

                            const action2 = document.createElement('i');
                            action2.setAttribute('class', "fa fa-trash fa-1x text-primary");
                            action2.setAttribute('style', "cursor: pointer;margin-left: 10px");
                            action2.setAttribute('onclick', "modifierStatutAppareil(" + device.id + ", "+id+")");

                            const deviceStatusCell = document.createElement('td');
                            const deviceAction = document.createElement('td');

                            deviceStatusCell.appendChild(span);
                            deviceAction.appendChild(action);
                            deviceAction.appendChild(action2);

                            row.appendChild(deviceNumberCell);
                            row.appendChild(deviceNameCell);
                            row.appendChild(deviceStatusCell);
                            row.appendChild(deviceAction);

                            tbody.appendChild(row);
                        });

                        table.appendChild(tbody);
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des données:', error);
                    });
            }

            function post_appareil() {

                console.log(id_piece)

                const selectElement = document.querySelector('#select_app');
                const id_appareil = selectElement.value;

                // Données à envoyer
                const data = {
                    id_piece: id_piece,
                    id_appareil: id_appareil
                };


                // Options de la requête
                const options = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                };

                // Appeler l'API pour envoyer l'ID
                fetch('/user-appareil', options)
                    .then(response => response.json())
                    .then(responseData => {
                        console.log('Réponse de l\'API:', responseData);
                        // Traiter la réponse de l'API si nécessaire
                        charger_appareil(id_piece)
                    })
                    .catch(error => {
                        console.error('Erreur lors de l\'envoi de l\'ID:', error);
                    });
            }

            function modifierStatutAppareil(idAppareil, idPiece) {
                // Construire l'URL de la requête GET avec les paramètres
                const url = "/appareil-status/"+idAppareil+"/"+idPiece;

                // Envoyer la requête GET
                fetch(url)
                    .then(response => response.json())
                    .then(responseData => {
                        charger_appareil(idPiece)
                    })
                    .catch(error => {
                        console.error('Erreur lors de la modification du statut de l\'appareil:');
                    });
            }
        </script>
    @endsection
