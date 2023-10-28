<?php
/**
 * Shows the upload file button which handles file uploads.
 * This view is used by FileUploadButtonWidget.
 *
 * If an FileUploadListWidget Instance is exists, this view should update some
 * informations like process or already uploaded files per javascript.
 *
 * Its also necessary to update the bindToFormFieldId on successful uploads.
 * This hidden field contains a list all uploaded file guids.
 *
 * @property String $uploaderId is the unique id of the uploader.
 * @property String $bindToFormFieldId is the id of the hidden id which stores a comma seprated list of file guids.
 *
 * @package humhub.modules_core.file.widgets
 * @since 0.5
 */
?>

<style>
    .fileinput-button {
        position: relative;
        overflow: hidden;
    }

    .fileinput-button input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        transform: translate(-300px, 0) scale(4);
        font-size: 23px;
        direction: ltr;
        cursor: pointer;
    }
</style>
<span class="btn btn-info fileinput-button tt" data-toggle="tooltip" data-placement="top" title=""
      data-original-title="<?php echo Yii::t('FileModule.widgets_views_fileUploadButton', 'Upload files'); ?>">
    <i class="fa fa-cloud-upload"></i>

    <input id="<?php echo $uploaderId; ?>" class="postfileupload" type="file" name="files[]"
           data-url="<?php echo Yii::app()->createUrl('//file/file/upload'); ?>" multiple>
</span>

<script>
    $(function () {

        $('.postfileupload').each(function () {

            $('#<?php echo $uploaderId; ?>').fileupload({
                dropZone: $(this),
                dataType: 'json',

                // After File is uploaded
                done: function (e, data) {

                    // Parses the given JSON Array returned by FileUpload Controller
                    // See application.modules_core.file.controllers.FileController
                    //      Method: handleFileUpload  for all available json informations.
                    $.each(data.result.files, function (index, file) {

                        // No Upload Error
                        if (!file.error) {

                            // Hidden Value Field, which holds a comma separetet list of
                            // all guids of uploaded files
                            hiddenValueField = $('#<?php echo $bindToFormFieldId; ?>');
                            hiddenValueField.val(hiddenValueField.val() + "," + file.guid);

                            // Attach a simple Li Entry
                            $('#<?php echo $uploaderId;?>_list').append('<li style="padding-left: 24px;" class="mime ' + file.mimeIcon + '">' + file.name + '</li>');

                        } else {
                            alert("Could not upload File: " + file.name + "\nReason:\n" + file.errorMessage);
                        }

                    });

                },

                progressall: function (e, data) {

                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    // Fix: remove focus from upload button to hide tooltip
                    $('#post_submit_button').focus();

                    // hide form buttons
                    $('.btn_container').hide();

                    // show progress bar
                    $('#<?php echo $uploaderId; ?>_progress').show();

                    if (progress == 100) {

                        // set upload status to 100
                        $('#<?php echo $uploaderId; ?>_progress').children().css('width', 100 + "%");

                        // hide progress bar
                        $('#<?php echo $uploaderId; ?>_progress').hide();

                        // show form buttons
                        $('.btn_container').show();

                        // show attached files
                        $('#<?php echo $uploaderId; ?>_list').fadeIn('slow');

                    } else {

                        // show progress bar
                        $('#<?php echo $uploaderId; ?>_progress').show();

                        // update upload status
                        $('#<?php echo $uploaderId; ?>_progress').children().css('width', progress + "%");
                    }

                    // Show Uploaded FileUploadList Widget if exists
                    $('#<?php echo $uploaderId; ?>_details').show();

                }

            }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

        })
    })


    /**
     * Resets State
     *
     * @param {type} uploaderId
     * @returns {undefined}     */
    function clearFileUpload(uploaderId) {
        $('#' + uploaderId + '_details').hide();
        $('#' + uploaderId + '_progress').html('0%');
        $('#<?php echo $uploaderId;?>_list').html('');
    }

</script>
