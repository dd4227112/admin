@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="box-title m-b-20">Basic FAQs</h4>
        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="font-bold">How much do you charge ? </a> </h4> </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"> If you need only payment integration solution, we will charge you Tsh 1000/= only per transaction. If you need other modules in the system, we will charge you based on number of modules that you need to use in your school. </div>
                </div>
            </div>
             <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapseOne" class="font-bold">How do we get started to use ShuleSoft ?</a> </h4> </div>
                <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"> You will sign an agreement form /or a contract with ShuleSoft, then we will assist you in data entry process and perform training to your staff to understand well how to use the software and get all the benefit it offer </div>
                </div>
            </div>
             <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapseOne" class="font-bold">How parents will access the system</a> </h4> </div>
                <div id="collapse2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"> ShuleSoft use internet. Parent will either download ShuleSoft app in their mobile phone or use computer to open shulesoft system for your school. Once parents open ShuleSoft, they will login with their username and password provided during installation of system in your school </div>
                </div>
            </div>
             <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapseOne" class="font-bold">Parents who don't have smartphone, what will they do ?</a> </h4> </div>
                <div id="collapse3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"> ShuleSoft also send normal SMS to parents to inform them about all activities in school. This includes exam reports, attendance, routine, payment status and any information sent by administrator via SMS</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title"> <a class="font-bold" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"> Is there any Data backup facility?</a> </h4> </div>
                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="true" style="">
                    <div class="panel-body">We use sophisticated backup technology as well, so in case of any disaster for the main data centre, your application and data will still be available at a remote secured backup location. No additional charges of back up.</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title"> <a class="font-bold" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Can I export the data from the software?</a> </h4> </div>
                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree" aria-expanded="true" style="">
                    <div class="panel-body">Yes, you can export into excel, Pdf, Print. You can as well import data from excel (users information,account information etc) into the system</div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour"> <a class="font-bold panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"> Is training provided on How to use ShuleSoft? </a> </div>
                <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour" aria-expanded="true" style="">
                    <div class="panel-body">Yes, FREE Training is provided. Our knowledge base in the software would just be enough for anyone to understand everything about the software but still we provide one-on-one training or webinars to help our customers.
We go step-by-step with you on how to use our software until you are comfortable to use it.</div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="col-md-12">
        <h4 class="box-title m-b-20">Advanced FAQs</h4>
        <div class="panel-group" id="exampleAccordionDefault" aria-multiselectable="true" role="tablist">
            <div class="panel">
                <div class="panel-heading" id="exampleHeadingDefaultOne" role="tab"> <a class="panel-title collapsed" data-toggle="collapse" href="#exampleCollapseDefaultOne" data-parent="#exampleAccordionDefault" aria-expanded="false" aria-controls="exampleCollapseDefaultOne"> Collapsible Group Item #1 </a> </div>
                <div class="panel-collapse collapse" id="exampleCollapseDefaultOne" aria-labelledby="exampleHeadingDefaultOne" role="tabpanel" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body"> De moveat laudatur vestra parum doloribus labitur sentire partes, eripuit praesenti congressus ostendit alienae, voluptati ornateque accusamus clamat reperietur convicia albucius, veniat quocirca vivendi aristotele errorem epicurus. Suppetet. Aeternum animadversionis, turbent cn partem porrecta c putamus diceret decore. Vero itaque incursione. </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading" id="exampleHeadingDefaultTwo" role="tab"> <a class="panel-title collapsed" data-toggle="collapse" href="#exampleCollapseDefaultTwo" data-parent="#exampleAccordionDefault" aria-expanded="false" aria-controls="exampleCollapseDefaultTwo"> Collapsible Group Item #2 </a> </div>
                <div class="panel-collapse collapse" id="exampleCollapseDefaultTwo" aria-labelledby="exampleHeadingDefaultTwo" role="tabpanel" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body"> Praestabiliorem. Pellat excruciant legantur ullum leniter vacare foris voluptate loco ignavi, credo videretur multoque choro fatemur mortis animus adoptionem, bello statuat expediunt naturales frequenter terminari nomine, stabilitas privatio initia paranda contineri abhorreant, percipi dixerit incurreret deorsum imitarentur tenetur antiopam latinam haec. </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading" id="exampleHeadingDefaultThree" role="tab"> <a class="panel-title" data-toggle="collapse" href="#exampleCollapseDefaultThree" data-parent="#exampleAccordionDefault" aria-expanded="true" aria-controls="exampleCollapseDefaultThree"> Collapsible Group Item #3 </a> </div>
                <div class="panel-collapse collapse in" id="exampleCollapseDefaultThree" aria-labelledby="exampleHeadingDefaultThree" role="tabpanel" aria-expanded="true" style="">
                    <div class="panel-body"> Horum, antiquitate perciperet d conspectum locus obruamus animumque perspici probabis suscipere. Desiderat magnum, contenta poena desiderant concederetur menandri damna disputandum corporum equidem cyrenaicisque. Defuturum ultimum ista ignaviamque iudicant feci incursione, reprimique fruenda utamur tu faciam complexiones eo, habeo ortum iucundo artes. </div>
                </div>
            </div>
        </div>
    </div>-->
</div>
@endsection