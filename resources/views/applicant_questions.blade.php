<?php $root = url('/') . '/public/' ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ShuleSoft Admin Panel</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Phoenixcoded">
  <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
  <meta name="author" content="Phoenixcoded">
  <!-- Favicon icon -->

  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/themify-icons/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/icon/icofont/css/icofont.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?= $root ?>assets/css/style.css?v=2">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
  integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" 
  crossorigin="anonymous"></script>



</head>
<body class="fix-menu"   style=" overflow-y:auto; height: auto;">
    <div class="container">
      <div class="page-wrapper">
        <div class="page-body">
          <div class="row">
            <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header ">
                    <h1 class="text-center" style="color: black; font-weight: bold;">
                    <img src="<?= $root ?>assets/images/auth/shulesoft_logo.png" alt="logo.png" width="80" height="80">
                     </h1>
                    <h4 class="text-center"><b>{{ $title }}</b></h4>

                    </div>
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="col-sm-12">
                               
                                <?php $i=1;  $questions = \App\Models\RecruimentQuestions::get(); ?>
                                    <?php foreach($questions as $key => $question){ ?>
                                      <h3 class="mt-0"><b> <?=$i++?>. <?php echo $question->question; ?> </b></h3>
                                      <?php $answers = \App\Models\QuizAnswers::get(); ?>
                                        <ol >
                                        @foreach($answers as $answer)
                                        
                                        <label class="container">
                                          <input type="radio" id="answer<?= $answer->id ?>" value="{{$answer->id}}" name="question{{$question->id}}"
                                            onclick="send_answer(<?= $answer->answer ?>,<?=$question->id?>)" required>
                                          <span class="checkmark"></span>
                                          {{ $answer->answer }}
                                        </label>
                                        
                                        @endforeach
                                      </ol>
                                     <br>
                                  <hr>
                      
                                <?php } ?>
                                   <a href="<?=url('Recruitments/quiz/'.$id.'/submit')?>" class="btn btn-warning pull-right"> Click to Submit </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


      </body>
      </html>



<script type="text/javascript">
send_answer = function (answer,quest_id) {
  var applicant_id = '<?=$id?>';
  $.ajax({
    type: 'POST',
    url: "<?=url('Recruitments/quizAnswers')?>",
    data: {"_token": "{{ csrf_token() }}",answer: answer,question_id: quest_id, recruiment_id: applicant_id},
    dataType: "html",
    success: function (data) {
      // $('#latest_comment' + id).after(data);
      // $('#comment_area' + id).hide();
      // $('#answeragain' + id).show();
      //   window.location.href = '';
    }
  });
}
</script>

