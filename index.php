<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Kevin Da Silva Pinto">

    <title>Secret Santa</title>

    <link rel="stylesheet" href="style/style.css">
    <link rel="shortcut icon" href="img/icon.ico" type="image/x-icon">

    <script>



        function createList(){
            var allNoms = document.getElementsByName("participants_secret[]"),
                arrayNom = [];
            for(var i = 0; i < allNoms.length; i++){
                var a = allNoms[i];
                arrayNom.push(a.value);
            }
            console.log(arrayNom);


            if(arrayNom.length == 0){
                document.getElementById("resultat").innerHTML = "";
                return;
            }else{
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        document.getElementById("resultat").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "createSanta.php?q="+arrayNom, true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<body>
    <div id="cont">
        <div id="titre">
            <!-- <img src="img/Y.jpg"> -->

            <h1>Secret Santa</h1>
        </div>

        <div id="contReste">
            <div class="infos">
<!--                 <p>Le nombre de participants <strong>doit</strong> être paire!</p>
 -->                <p>Vous avez <span id="nbCountParticipant">4</span> participants</p>
            </div>

            <div id="alert"></div>

            <div id="participants">
                <div id="cont_partici">
                    <?php for($i = 1; $i < 5; $i++){ ?>
                        <div class="participant" id="part_<?php echo $i; ?>">
                            <input type="text" class="NomParticipant" name="participants_secret[]" id="input_parti_<?php echo $i; ?>" autocomplete="off" pattern="[A-Za-z]{3,}" placeholder="Nom du participant" required="required">
                            <div class="delete_parti">
                                <a onClick="return deleteParticipant(<?php echo $i; ?>);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div id="add_partici">
                    <div id="addParti">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>
                    </div>
                    <div id="textAdd">
                        <p>Ajouter</p>
                    </div>
                </div>
            </div>

            <div id="btnGenerer">
                <div id="GENERER">
                    Générer
                </div>
            </div>

            <div id="resultat">

            </div>
        </div>
    </div>

    <script>
        document.getElementById('btnGenerer').onclick = function(){
            if (isEveryInputEmpty()){
                alert('Tout les champs doivent être rempli !');
            }else{
                //alert('not empty');
                createList();
            }
        };

        const isEveryInputEmpty = () => {
            var inputs = document.querySelectorAll('.NomParticipant');
            
            for (const input of inputs)
                if (input.value == '') return true;
                
            return false;
        }




        function deleteParticipant(num_parti){
            var nom_participant = "";
            if(document.getElementById("input_parti_"+num_parti).value != ""){
                nom_participant = ' "'+document.getElementById("input_parti_"+num_parti).value+'"';
            }

            if(confirm("Supprimer le participant N°"+num_parti+""+nom_participant+" ?") == true){
                // Supprimer le candidat
                var elem = document.getElementById("part_"+num_parti);
                elem.remove();
            }
            countParti();
        }

        var addParticipantBtn = document.getElementById("add_partici"),
            creationNb = 5;
        addParticipantBtn.onclick = function(){
            // Ajouter un nouveau participant 
            var participantBox = document.getElementById("cont_partici");

            // participantBox.innerHTML+='<div class="participant" id="part_'+creationNb+'"><input type="text" class="NomParticipant" name="participants_secret[]" id="input_parti_'+creationNb+'" autocomplete="off" pattern="[A-Za-z]{3,}" placeholder="Nom du participant" required="required"><div class="delete_parti"><a onClick="return deleteParticipant('+creationNb+');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/></svg></a></div></div>';

            document.getElementById('cont_partici').insertAdjacentHTML("beforeend",'<div class="participant" id="part_'+creationNb+'"><input type="text" class="NomParticipant" name="participants_secret[]" id="input_parti_'+creationNb+'" autocomplete="off" pattern="[A-Za-z]{3,}" placeholder="Nom du participant" required="required"><div class="delete_parti"><a onClick="return deleteParticipant('+creationNb+');"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/></svg></a></div></div>');

            creationNb+=1;

            countParti();
        }

        function countParti(){
            var nbParti = document.getElementsByClassName("participant").length,
                divAlert = document.getElementById('alert'),
                spanCount = document.getElementById('nbCountParticipant');

            spanCount.innerText=nbParti;
            /* divAlert.innerText="";
            if(nbParti % 2 != 0){
                divAlert.innerText="Attention, le nombre de participants est impair.";
            } */
        }
    </script>
</body>
</html>