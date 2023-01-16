<?php

require('./endpoints.php');

if (!file_exists('topics')) {
    mkdir('topics', 0777, true);
}


if (!file_exists('subtopics')) {
    mkdir('subtopics', 0777, true);
}

// print_r(getAllBatches());

if($_GET['action'] == 'importBatches'){

  $email = @getProfile()['id'];
$old_batches = @get_json('batches_un.json');

if($email){
      $old_batches[$email] = [];

foreach(getAllBatches() as $batch){
  if($batch['feeId']['amount'] != 0){
    $cur_batch = new stdClass();
    $cur_batch->id = $batch["_id"];
    $cur_batch->name = $batch["name"];
    $cur_batch->board = $batch["board"];
    $cur_batch->class = $batch["class"];
    $cur_batch->exam = $batch["exam"];
    $cur_batch->previewImage = $batch["previewImage"];

    $batchdet = getBatchDetails($batch["_id"]);
    
    $cur_batch->details = $batchdet;
        $old_batches[$email][] = $cur_batch; 
    echo '<b>Adding batch '.$cur_batch->name.'<br><br></b>';
    
  }
}
  save_json('batches_un.json',$old_batches);

  echo '<script>location.replace("jsonadd.php")</script>';
}
  
}

if($_GET['action'] == 'importBatch' && isset($_GET['batch_id'])){
$batch_id = $_GET['batch_id'];
$batchdet = getBatchDetails($batch_id);
$subjects = $batchdet["subjects"];
$batchSlug = $batchdet["slug"];
    
foreach($subjects as $subject){
    $subject_data = getTopicDetails(urlencode($batchSlug),$subject["slug"]);

  
  foreach($subject_data as $index => $topic){

    $subject_data[$index]["_id"] = $subject["slug"].$topic["slug"];
      
    $suptopic = new stdClass();
    $suptopic->videos = getSubTopicDetails(urlencode($batchSlug), $subject["slug"], $topic["slug"],'videos');
    $suptopic->notes = getSubTopicDetails(urlencode($batchSlug) ,$subject["slug"], $topic["slug"],'notes');
        $suptopic->DppNotes = getSubTopicDetails(urlencode($batchSlug) ,$subject["slug"], $topic["slug"],'DppNotes');
        $suptopic->DppVideos = getSubTopicDetails(urlencode($batchSlug) ,$subject["slug"], $topic["slug"],'DppVideos');
         $suptopic->exercises = getSubTopicDetails(urlencode($batchSlug) ,$subject["slug"], $topic["slug"],'exercises');


      $saveto = "subtopics/".$subject["slug"].$topic["slug"].".json";
    save_json($saveto,$suptopic);

echo 'Adding Topic:'.$topic["name"]." in <b>".$batchdet["name"].'</b><br><br>';
    
    }

  // print_r($subject_data);
  
  $savetoSub = "topics/".$subject["_id"].".json";
      save_json($savetoSub,$subject_data);

    
  }
    echo '<script>location.replace("jsonadd.php")</script>';

}


  
if($_GET['action'] == 'addEverything'){
$email = @getProfile()['id'];
$old_batches = @get_json('batches_un.json');

if($email){
    $old_batches[$email] = [];

foreach(getAllBatches() as $batch){
  if($batch['feeId']['amount'] != 0){
    $cur_batch = new stdClass();
    $cur_batch->id = $batch["_id"];
    $cur_batch->name = $batch["name"];
    $cur_batch->board = $batch["board"];
    $cur_batch->class = $batch["class"];
    $cur_batch->exam = $batch["exam"];
    $cur_batch->previewImage = $batch["previewImage"];

    $batchdet = getBatchDetails($batch["_id"]);
    
    $cur_batch->details = $batchdet;


    $old_batches[$email][] = $cur_batch; 
    echo '<b>Adding batch '.$cur_batch->name.'<br><br></b>';
    

    $subjects = $batchdet["subjects"];
    
 //print_r($subjects);
    
foreach($subjects as $subject){
    $subject_data = getTopicDetails($batch["_id"], $subject["_id"]);

  $saveto = "topics/".$subject["_id"].".json";
    save_json($saveto,$subject_data);
  
//print_r($saveto);
  foreach($subject_data as $topic){
    //  types:
    //  videos
    //  notes
    // DppNotes
    // DppVideos
    $suptopic = new stdClass();
    $suptopic->videos = getSubTopicDetails($batch["_id"], $subject["_id"], $topic["_id"],'videos');
    $suptopic->notes = getSubTopicDetails($batch["_id"], $subject["_id"], $topic["_id"],'notes');
        $suptopic->DppNotes = getSubTopicDetails($batch["_id"], $subject["_id"], $topic["_id"],'DppNotes');
        $suptopic->DppVideos = getSubTopicDetails($batch["_id"], $subject["_id"], $topic["_id"],'DppVideos');
    
            $suptopic->exercises = getSubTopicDetails($batch["_id"], $subject["_id"], $topic["_id"],'exercises');


    // print_r($suptopic);

      $saveto = "subtopics/".$topic["_id"].".json";
    save_json($saveto,$suptopic);

echo 'Adding Topic:'.$topic["name"]." in <b>".$batch["name"].'</b><br><br>';
    
    }
    
  }
    
}
}
save_json('batches_un.json',$old_batches);
    echo '<script>location.replace("jsonadd.php")</script>';

}
}




function save_json($path,$array){
 // $fp = fopen($path, 'w');
//fwrite($fp, json_encode($array));
//fclose($fp);
  return file_put_contents($path,json_encode($array));
  
}

function get_json($path){ return json_decode(file_get_contents($path), true);
  
}

?>





  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

      <style>
        
a{
  margin-left: 2px;
}

td {
    word-break: break-all;
}

span.card-title {
    background: rgba(0,0,0,0.8);
}

/* th,td{
    border: 1px solid black;
    padding: 8px;
} */

/* input{
background-color: #cbb007!important;
} */
.tabs .tab a {
  color: black !important;
  font-weight: bold;
  font-size: 10px !important;
}

.row {
  margin-bottom: 5px !important;
}

.brand {
  color: black !important;
  font-weight: 500;
  font-size: 13.5px;
}

.brand-btn {
  background-color: #cbb007 !important;
}

.brand-btn:focus {
  background-color: #6e6000 !important;
}

label {
  font-weight: 600;
  width: 100px;
  font-size: .9em !important;
}

select {
  display: block !important;
}

.okok {
  margin-left: 6px;
  margin-top: 6px;

}



.hiddenn {
  display: none !important;
}

      </style>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
      <div class='container'>
        <br>
        <div class='buttons'>
        <a class="waves-effect waves-light btn red" href="?action=addEverything">import everything (Caution:Causes Server LOAD)</a>
                  <a class="waves-effect waves-light btn" href="?action=importBatches">import batches</a>
 <a class="waves-effect waves-light btn" href="filter_pw_batches.php">optimize batches</a>
          <div>
      </div>


<!--batches -->

            <br><br>
                 <div class="row batches">
      
                      <?php 
$old_batches = @get_json('batches_un.json');
         if($old_batches){
             foreach($old_batches[@getProfile()['id']] as $batch){
          ?>
    <div class="col s6 m6 l4">

                  <br><br>
            <br><br>

      <div class="card">
        <div class="card-image">
          <img src="<?php echo $batch["previewImage"]["baseUrl"].$batch["previewImage"]["key"]; ?>" style="opacity: 0.8;">
          <span class="card-title"><?php echo $batch["name"] ?></span>
        </div>

        <div class="card-action">
          <a class="waves-effect waves-light btn" href="?action=importBatch&batch_id=<?php echo $batch["id"] ?>">Import Batch</a>

                    <a class="waves-effect waves-light btn" href="/khazanaadd.php?action=importKhazana&batch_id=<?php echo $batch["id"] ?>">Import khazana</a>

          
        </div>
      </div>

                      </div>


            <?php
         }
         }
           ?>

  </div>
            
    </body>

      <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  </html>
        