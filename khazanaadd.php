<?php

require('./endpoints.php');
ini_set('max_execution_time', '0'); // for infinite time of execution 
set_time_limit(0);


if (!file_exists('khazana/chapters')) {
    mkdir('khazana/chapters', 0777, true);
}

if (!file_exists('khazana/subjects')) {
    mkdir('khazana/subjects', 0777, true);
}




function save_json($path,$array){
 // $fp = fopen($path, 'w');
//fwrite($fp, json_encode($array));
//fclose($fp);
  return file_put_contents($path,json_encode($array));
  
}

function get_json($path){ return json_decode(file_get_contents($path), true);
  
}


$load_html = false;
$showchapters = false;

if($_GET['action'] == 'importKhazana' && isset($_GET['batch_id'])){
$load_html = true;
}





function run($command, $outputFile = 'runlock.txt') {
    $processId = shell_exec(sprintf(
        '%s > %s 2>&1 & echo $!',
        $command,
        $outputFile
    ));
       
      print_r("processID of process in background is: "
        . $processId);
}

if($_GET['action'] == 'importKhazanaChs' && isset($_GET['kh_id'])){

$khazanaProgramId = $_GET['kh_id'];
$khazanaProgramData = getKhazanaDetails($khazanaProgramId);
$old_khazana = @get_json('khazana.json');

$khzslug= $khazanaProgramData['slug'];
  
$khazana_subjects = getKhazanaSubjects($khzslug);
  
$new = true;
  
foreach($old_khazana as $khazana){
  if($khazanaProgramId == $khazana["_id"]){
    $new = false;
  }
}


  if($new){
    $old_khazana[] = $khazanaProgramData;
      save_json('khazana.json',$old_khazana);
  }

  
  
foreach($khazana_subjects as $key=>$subject){
  $subject_slug = $subject['slug'];
  
    $subject_data = getKhazanaChapters($khzslug,$subject_slug);

      $subject['chapters'] = $subject_data;
  
$khazana_subjects[$key] = $subject;
  
  foreach($subject_data as $topic){
echo 'Adding Topic:'.$subject["name"]." in <b>".$topic["description"].'</b><br><br>';  
    }
  

  // print_r($subject_data);

    
  }

        save_json("khazana/subjects/$khazanaProgramId.json",$khazana_subjects);


  
   echo "<script>location.replace('/khazanaadd.php?action=importKhazana&batch_id={$_GET["batch_id"]}')</script>";

}







if($_GET['action'] == 'importKhazanaSubject' && isset($_GET['kh_subs_index']) && isset($_GET['kh_id'])){
  $showchapters = true;
  $khazanaProgramId = $_GET['kh_id'];
  
  $subjects = @get_json("khazana/subjects/$khazanaProgramId.json");
  $index = $_GET['kh_subs_index'] - 10;
  
  $khazanaProgramData = getKhazanaDetails($khazanaProgramId);

  
  $khslug = $khazanaProgramData['slug'];
  $subject = $subjects[$index];
  $sub_slug = $subject['slug'];
  $chapters = $subject['chapters'];
 

     // echo "<script>location.replace('/khazanaadd.php?action=importKhazana&batch_id={$_GET["batch_id"]}')</script>";


}

if($_GET['action'] == 'importKhazanach' && isset($_GET['kh_subs_index']) && isset($_GET['kh_ch_index']) && isset($_GET['kh_id'])){
  //khazanaadd_back.php

  if( strpos(file_get_contents("runlock.txt"),"DONE DONE DONE") !== false) {    
file_put_contents("currbatch.txt",$_GET['batch_id']);
file_put_contents("runlock.txt","");
// "sleep 5" process will run in background
run("php khazanaadd_back.php ".$_GET['kh_subs_index']." ". $_GET['kh_ch_index'] . " ".$_GET['kh_id']);
  
print_r("Task Added.processID is: ".getmypid());
}else{
  echo "wait for previous batch to import fully\n";
}
  sleep(2);

    $khazanaProgramId = $_GET['kh_id'];
  
  // $subjects = @get_json("khazana/subjects/$khazanaProgramId.json");
  $index = $_GET['kh_subs_index'] - 10;
  // $chindex = $_GET['kh_ch_index'] - 10;
  
  // $khazanaProgramData = getKhazanaDetails($khazanaProgramId);

  
  // $khslug = $khazanaProgramData['slug'];
  // $subject = $subjects[$index];
  // $sub_slug = $subject['slug'];
  //   $chapters = $subject['chapters'];

  // $ch = $chapters[$chindex];
  //     $chslug = $ch['slug'];
  //   $chid = $ch['_id'];
    
  //   echo 'Adding Chapter: <b>'.$ch["description"].' in </b> '.$subject["name"].'<br><br>';  

  //   $topics = getKhazanaTopics($khslug,$sub_slug,$chslug);
    
  //     foreach($topics as $topic_index => $tc){
  //       $topic_id = $tc['_id'];
  //       $sub_topics = getKhazanaSubTopics($khslug,$sub_slug,$chslug,$topic_id);
        
  //             foreach($sub_topics as $sub_topic_index => $stc){
  //             $sub_topic_id = $stc['_id'];
  //             $sub_sub_topics = getKhazanaSubSubTopics($khslug,$sub_slug,$chslug,$topic_id,$sub_topic_id);
  //             $sub_topics[$sub_topic_index]['sub_topic_data'] = $sub_sub_topics;
  //               // print_r($sub_sub_topics);
  //             }
        
  //            $topics[$topic_index]['sub_topics'] = $sub_topics;
        
  //     }
  //   $kkkk = $index+10;
  
        $kkkk = $index+10;

  //   save_json("khazana/chapters/$chid.json",$topics);
       echo "<script>location.replace('/khazanaadd.php?action=importKhazanaSubject&kh_subs_index=$kkkk&kh_id=$khazanaProgramId')</script>";

}




  if($load_html){

    $batch_id = $_GET['batch_id'];
$batchdet = getBatchDetails($batch_id);
  $khazanaProgramId = $batchdet["khazanaProgramId"];

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

                  <a class="waves-effect waves-light btn" href="?action=importKhazanaChs&kh_id=<?php echo $khazanaProgramId; ?>&batch_id=<?php echo $_GET["batch_id"]; ?>">import Khazana Subjects</a>
          <div>
      </div>


<!--batches -->

                 <div class="row batches">
      
                      <?php 
$old_batches = @get_json("khazana/subjects/$khazanaProgramId.json");
    
         if($old_batches){
             foreach($old_batches as $key=>$batch){
          ?>
    <div class="col s6 m6 l4">

                  <br><br>
            <br><br>

      <div class="card">
        <div class="card-image">
          <img src="https://i.ibb.co/nBr3pfc/Screenshot-2022-09-27-153547.png" style="opacity: 0.8;">
          <span class="card-title"><?php echo $batch["name"] ?></span>
        </div>

        <div class="card-action">
          <a class="waves-effect waves-light btn" href="?action=importKhazanaSubject&kh_subs_index=<?php echo $key +10 ; ?>&kh_id=<?php echo $khazanaProgramId ; ?>" target="_blank">Import this</a>

          
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


    <?php
  }
?>

<?php
if($showchapters){

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

 
          <div>
      </div>


<!--batches -->

                 <div class="row batches">
      
                      <?php 
    
         if($chapters){
             foreach($chapters as $key=>$batch){
          ?>

                  <br>



          <a class="waves-effect waves-light btn" href="?action=importKhazanach&kh_subs_index=<?php echo $index +10 ; ?>&kh_ch_index=<?php echo $key +10 ; ?>&kh_id=<?php echo $khazanaProgramId ; ?>" >Import <?php echo $batch["name"]." ".$batch["description"]; ?> </a>
<br>
          



            <?php
         }
         }
           ?>

  </div>
            
    </body>

      <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  </html>



          <?php
}
?>