<?php
namespace Leap\View;
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

/**
 * Description of InputFoto
 *
 * @author User
 */
class InputFoto extends Html {
    public function __construct ($id, $name, $value, $classname = 'form-control')
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public static function getAndMakeFoto ($src, $id)
    {
        $src2 = self::getFoto($src);

        return self::makeFoto($src2, $id);
    }

    public static function getFoto ($src)
    {
        // echo $src;
        $name = (isset($src) ? _PHOTOURL . $src :  "images/noimage.jpg");
        if ($name == _PHOTOURL . "foto") {
            $name =  "images/noimage.jpg";
        }

        return $name;
    }

    public static function makeFoto ($src, $id)
    {
        $str = '
    <div class="foto100">
    <img src="' . $src . '" id="' . $id . '" onload="OnImageLoad(event,100);">
    </div>';

        return $str;
    }

    public function p ()
    {
        $t = time();
        $src = self::getFoto($this->value);
        ?>
        <span id="<?= $this->id; ?>_<?= $t; ?>">
    <?
    $id = "holder_foto_old_" . $t;
    echo self::makeFoto($src, $id);
    ?>
    <input type="file" name="file_<?= $this->name; ?>" id="file_<?= $this->id; ?>" value="<?= $this->value; ?>">
    <input type="hidden" name="<?= $this->name; ?>" id="<?= $this->id; ?>" value="<?= $this->value; ?>">
</span>
        <script type="text/javascript">

            document.querySelector('#<?=$this->id;?>_<?=$t;?> input[type=file]').addEventListener('change', function (event) {
                // Read files
                var files = event.target.files;
                //alert('in');
                //console.log(files);
                // Iterate through files
                for (var i = 0; i < files.length; i++) {
                    // alert('in2');
                    // Ensure it's an image
                    if (files[i].type.match(/image.*/)) {
                        var reader = new FileReader();
                        //alert('in3');
                        //console.log(reader);
                        reader.onload = function (readerEvent) {
                            // alert('in3b');
                            var image = new Image();
                            //alert('in4');
                            //console.log(image);
                            image.onload = function (imageEvent) {
                                // Resize image
                                var canvas = document.createElement('canvas'),
                                    max_size = 1200,
                                    width = image.width,
                                    height = image.height;
                                if (width > height) {
                                    if (width > max_size) {
                                        height *= max_size / width;
                                        width = max_size;
                                    }
                                } else {
                                    if (height > max_size) {
                                        width *= max_size / height;
                                        height = max_size;
                                    }
                                }
                                canvas.width = width;
                                canvas.height = height;
                                canvas.getContext('2d').drawImage(image, 0, 0, width, height);

                                //alert('in');

                                // Upload image
                                var xhr = new XMLHttpRequest();
                                if (xhr.upload) {

                                    // Update progress
                                    xhr.upload.addEventListener('progress', function (event) {
                                        var percent = parseInt(event.loaded / event.total * 100);
                                        //progressElement.style.width = percent+'%';
                                    }, false);

                                    // File uploaded / failed
                                    xhr.onreadystatechange = function (event) {
                                        if (xhr.readyState == 4) {
                                            if (xhr.status == 200) {

                                                //imageElement.classList.remove('uploading');
                                                //imageElement.classList.add('uploaded');
                                                var imageHtml = document.getElementById("holder_foto_old_<?=$t;?>");

                                                imageHtml.removeAttribute("style");
                                                imageHtml.removeAttribute("width");
                                                imageHtml.removeAttribute("height");
                                                imageHtml.src = '<?=_SPPATH;?>'+'<?=_PHOTOURL;?>' + xhr.responseText;
                                                $('#<?=$this->id;?>_<?=$t;?> #<?=$this->id;?>').val(xhr.responseText);
                                                //imageHtml.onload(function(){resizeAndJustify("holder_foto_old_<?=$t;?>",100);});
                                                //document.getElementById('progress_fotodatamurid_<?=$t;?>').style.display = 'none';
                                                //$('loadingtop').fade();
                                                //$('oktop').fade().fade();
                                                console.log('Image uploaded: ' + xhr.responseText);
                                                /*$('close_button_pop1').onClick(function(){
                                                 $('content_utama').load('
                                                <?=_SPPATH;?>datamurid/harmonica_widget?aj=1',{spinner:"loadingtop"});
                                                 $('pop1').hide();
                                                 });*/

                                            } else {
                                                //imageElement.parentNode.removeChild(imageElement);
                                            }
                                        }
                                    }

                                    // Start upload
                                    xhr.open('post', '<?=_SPPATH;?>uploader/uploadres?adafile=<?= $this->value; ?>&fname='+$("#file_<?= $this->id; ?>").val(), true);
                                    xhr.send(canvas.toDataURL('image/jpeg'));

                                }
                            }
                            image.src = readerEvent.target.result;

                        }
                        reader.readAsDataURL(files[i]);

                    }
                }

            });
        </script>
    <?
    }
}
