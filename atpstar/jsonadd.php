<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


require('./endpoints.php');

if (!file_exists('planner')) {
    mkdir('planner', 0777, true);
}

if (!file_exists('subtopics')) {
    mkdir('subtopics', 0777, true);
}




// if (!file_exists('announcements')) {
//     mkdir('announcements', 0777, true);
// }

// print_r(getAllBatches());

if(@$_GET['action'] == 'addBatches'){

  $email = @getProfile()['data'][0]['email'];


$old_batches = @get_json('batches.json');

 // echo 'adding'.$email;
  
if($email){
      $old_batches[$email] = [];
$new = getAllBatches();
  
foreach($new["data"] as $cur_batch){
    $old_batches[$email][] = $cur_batch; 
    echo '<b>Adding batch '.$cur_batch['subject_name'].'<br><br></b>';
}

  save_json('batches.json',$old_batches);

  echo '<script>location.replace("jsonadd.php")</script>';
}
  
}


if($_GET['action'] == 'importBatch' && isset($_GET['batch_id'])){
  
$batch_id = $_GET['batch_id'];
$batchplaner =getStudyPlannerofBatch($batch_id);
  $batchplan = $batchplaner["data"]["subject_category_list"];


  //adding chapterlists
  foreach($batchplan as $ind=>$singleWeek){
    if(count($singleWeek["chapter_list"]) == 0){
      $plan = getStudyPlannerofBatchByChapterId($batch_id,$singleWeek["subject_category_id"]);
      
        foreach($plan as $singleWeekplan){
         if($singleWeekplan["chapter_list"]){
           if($singleWeekplan['subject_category_id'] == $singleWeek["subject_category_id"]){
             $batchplan[$ind]["chapter_list"] = $singleWeekplan["chapter_list"];
           }
         }
        }
     
    }
  }

  
  print_r($batchplan);
  
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
        <a class="waves-effect waves-light btn" href="?action=addBatches">import batches</a>
          <div>
      </div>


<!--batches -->

            <br><br>
                 <div class="row batches">
      
                      <?php 
$old_batches = @get_json('batches.json');
         if($old_batches){
             foreach($old_batches[@getProfile()['data'][0]['email']] as $batch){
          ?>
    <div class="col s6 m6 l4">

                  <br><br>
            <br><br>

      <div class="card">
        <div class="card-image">
          <img src="<?php echo $batch["banner_image_mobile"]; ?>" style="opacity: 0.8;">
          <span class="card-title"><?php echo $batch["subject_name"] ?></span>
        </div>

                        <div class="card-action">
           <a class="waves-effect waves-light btn" href="?action=importBatch&batch_id=<?php echo $batch["subject_id"] ?>">Import Batch</a>
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
        