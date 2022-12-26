<?php
$q = $_REQUEST["q"];
$sendSanta = [];
//$send = preg_split("[\s,]+/", $q);
$send = array_map('trim', explode(',', $q));
shuffle($send);


$myFile = fopen("secret_Santa.txt", "w");


$liste1 = $liste2 = $send;
$nbPers = count($liste1);
$randNum = mt_rand(1, $nbPers-=1);

//array_push($sendSanta, $nbPers." - ".$randNum." - ".$liste1[0]."→".$liste2[$randNum]);
array_push($sendSanta, $liste1[0]."→".$liste2[$randNum]);
fwrite($myFile, $liste1[0]." - ".$liste2[$randNum]."\n");
?>
<div class="card">
    <div class="up"><?php echo $liste1[0]; ?></div>
    <div class="to"><span>↓</span></div>
    <div class="down"><?php echo $liste2[$randNum]; ?></div>
</div>
<?php

// Supprimer
//unset($liste2[$randNum]);
//sort($liste2);
array_splice($liste2, array_search($liste2[$randNum], $liste2), 1);

/*print_r($liste2);
echo '<br>';
echo '<br>';*/

for($i=1; $i < $nbPers; $i++){
    $nbPers2 = count($liste2);
    $nbMax = $nbPers2-=1;
    do{
        $randNum2 = mt_rand(1, $nbMax);
    }while($liste2[$randNum2] == $liste1[$i]);

    //echo '<p>'.$nbPers2.' - '.$randNum2.'</p>';
    array_push($sendSanta, $liste1[$i]."→".$liste2[$randNum2]);
    fwrite($myFile, $liste1[$i]." - ".$liste2[$randNum2]."\n");
    //unset($liste2[$randNum2]);

    //sort($liste2);
?>
<div class="card">
    <div class="up"><?php echo $liste1[$i]; ?></div>
    <div class="to"><span>↓</span></div>
    <div class="down"><?php echo $liste2[$randNum2]; ?></div>
</div>
<?php
    array_splice($liste2, array_search($liste2[$randNum2], $liste2), 1);
}

array_push($sendSanta, $liste1[$nbPers]."→".$liste2[0]);
fwrite($myFile, $liste1[$nbPers].' - '.$liste2[0]);
?>
<div class="card">
    <div class="up"><?php echo $liste1[$nbPers]; ?></div>
    <div class="to"><span>↓</span></div>
    <div class="down"><?php echo $liste2[0]; ?></div>
</div>

<div class="file card">
    <a href="secret_Santa.txt" title="Télécharger le fichier texte" download>
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0z"/>
        </svg>
    </a>
</div>
<?php
fclose($myFile);
// Output
//print_r($sendSanta);
?>