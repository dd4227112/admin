@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h4 class="box-title m-b-20">Basic FAQs</h4>
        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="font-bold">Your price is expensive ? </a> </h4> </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"> Clarify clearly with simple calculations why our price is low and affordable to any school. Make simple calculation, tell him/her that, if you compare how much you loose when you work without this system in calculation is high compared to what you will invest. How, if you list all tasks done by this system and you decide to higher people to do those tasks, you will pay more salary. Second, if you consider the time that you loose compared to what the software will help you  to save that time, you will also notice the expense. Third, you will now that, we bring value to your management, operation (teachers and staff) and to your parents, in this case you can as well let parents contribute bse for them they loose more than 10,000 per year to visit school and ask for student performance while they can view in their phone and computers </div>
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