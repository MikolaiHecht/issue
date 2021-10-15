<?php
/** @var NewsLetterList $controller */
$news=$controller->getNewsLetters();
$message=$controller->getStatusMessage();
$htaccesID = ($_SERVER['REMOTE_USER'] ) ? $_SERVER['REMOTE_USER'] : $_SERVER['REDIRECT_REMOTE_USER'];
?>
<main>
        <?php if($message!=""){ ?>
        <div class="statusBox" style="display: none; <?php if($message[0]== "error"){echo "background-color:red; color: white;";}elseif ($message[0]=="success"){echo "background-color:green;";} ?> "><?php echo $message[1];?></div>
        <script>
                $('.statusBox').show();
            setTimeout( function() {
                $('.statusBox').slideToggle()
            },5000);
        </script>
        <?php } ?>

        <div class="container" style="height: 50px;">
    <h2 style="float: left">Bisherige Newsletter</h2><h2><a class="btn-block buttons" style="padding: 0;width: 28px;height: 31px; float: right;" href=".">&#8634;</a></h2>
    </div>
        <div>   </div>
    <div class="container" style="flex-grow: 0">

        <?php foreach($news as $key =>$newsUpdate){
            $newsSplit=explode("_",$newsUpdate) ?>
        <form id="<?php echo $key; ?>" method="post" action="<?php echo $controller->getUrl('');?>">
        <div class="row">
            <div class="col">
                <h4 class="inlineBlock"><?php echo $controller->getNewsDate($newsSplit[0]);?></h4>
            </div>
            <div class="col">
                <h4 class="inlineBlock"><?php echo $newsUpdate;?></h4>
            </div>
            <div class="w-100 d-lg-none"></div>
            <div class="col">
                <a class=" btn-block buttons" target="_blank" href="<?php echo $controller->getUrl("newsletter/".$newsUpdate);?>" >&#x1f441;</a>
            </div>
            <?php if($htaccesID =="admin"){ ?>
                <div class="col">
                    <form id="<?php echo $key.$key; ?>" method="post" action="<?php echo $controller->getUrl('');?>" >
                        <input type="hidden" name="action" value="deleteNewsLetter">
                        <input type="hidden" name="controller" value="NewsLetterList">
                        <input type="hidden" name="newsLetterToDelete" value="<?php echo $newsUpdate; ?>" >
                        <button class=" btn-block buttons" onclick="submitForm(<?php echo $key.$key; ?>)">&#8416;</button>
                    </form>
                </div>
            <div class="col">
                <button class=" btn-block buttons" onclick="submitForm(<?php echo $key; ?>)" >&#9993;</button>
            </div>
                <div class="w-100 d-sm-none"></div>
                <div class="col">
                    <input type="hidden" name="action" value="sendEmail">
                    <input type="hidden" name="controller" value="NewsLetterList">
                    <input type="hidden" name="newsLetterToSend" value="<?php echo $newsUpdate; ?>" >
                    <input class="emailInput" placeholder="Empf&auml;nger" name="emailInput" type="text">
                </div>
                <div class="col">
                    <input class="emailInput" placeholder="Betreff" name="subjectInput" type="text" >
                </div>
            <?php } ?>
        </div>
        </form>
        <?php } ?>
    </div>
    <?php if($htaccesID =="admin"){ ?>
    <div class="container">
        <h2>NewsLetterUpload</h2>
        <table class="table">
            <tr>
                <td>
                    <form method="post" action="" enctype="multipart/form-data" id="fileUpload">
                        <input type="hidden" name="action" value="fileUpload" id="form_action" >
                        <input type="hidden" name="controller" value="NewsLetterList" id="form_controller">
                        <div>
                            <label class="orange noOutline" id="imageFileInput" for="newsletterFile">
                                <input style="display: none" type="file" id="newsletterFile" class="inputfile" name="file" accept="text/html">
                                <span id="fileShow" class=" btn-block buttons " style="cursor: pointer;" onclick="getFilesOutOfHtml()"> Choose File </span>
                            </label>
                            <button id="button_upload" style="margin-top: 10px" class=" btn-block buttons" onclick="submitForm('fileUpload')">Send File</button>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <?php } ?>
</main>
<script>
    function submitForm(key) {
        document.getElementById(key).submit();
    }
    function prevent(event) {
        event.preventDefault();
    }

    function getFilesOutOfHtml() {
        var inputs = document.querySelectorAll('.inputfile');
        Array.prototype.forEach.call(inputs, function (input) {
            var label = input.nextElementSibling,
                labelVal = label.innerHTML;

            input.addEventListener('change', function (e) {
                var fileName = '';
                if (this.files && this.files.length > 1){
                    fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                }else{
                    fileName = e.target.value.split('\\').pop();
                }
                if (fileName){
                    $('#fileShow').html(fileName);
                }else{
                    $('#fileShow').html(labelVal);
                }
            });
        });
    }
</script>