function updateDataTable()
{
    let url = "http://147.175.98.78/cv2/handlers/GetTableDataHandler.php";
    let searchParams = new URLSearchParams(window.location.search);
    if (searchParams.has('subdir'))
        url += "?subdir=" +searchParams.get('subdir');
    $.get(url,
        function (data) {
            let json = JSON.parse(data);
            $("#table_id").DataTable({
                data: json,
                "searching": false,
                "paging": false,
                "bInfo": false,
                "scrollY":"80%",
                "scrollCollapse": true,
                "destroy": true,
            });
        });
}

$(document).ready( function () {
    updateDataTable()
} );

function showUploadForm()
{
    if($('#uploader_div').css('display') == 'none'){
        $('#uploader_div').show('slow');
    } else {
        $('#uploader_div').hide('slow');
    }
}

$("#file-upload").change(function(){
    $("#file-name").text(this.files[0].name);
});

function displayMessage(response)
{
    updateDataTable();
    $('#uploader_div').hide('slow');
    var message = $('<div class="alert alert-error error-message" style="display: none;">');
    var close = $('<button type="button" class="close" data-dismiss="alert">&times</button>');
    message.append(close); // adding the close button to the message
    message.append(response);
    message.appendTo($('body')).fadeIn(300).delay(3000).fadeOut(1500);
}

function clearFormInputs() // clear forms after upload
{
    $("#uploadedFileName").val('');
    $("#file-upload").val('');
    $("#file-name").text('');
}

function apiSaveUploadedFile(dataObject)
{
    $.ajax({
        url: 'http://147.175.98.78/cv2/handlers/fileHandler.php',
        type: 'post',
        data: dataObject,
        contentType: false,
        processData: false,
        success: displayMessage,
    });
}

$("#post-btn").click(function(){
    if (!$("#uploadedFileName").val().trim().length){
        displayMessage("Názov súboru nemôže byť prázdny.");
        return;
    }
    var form = $('form')[0];
    var fd = new FormData(form);

    // Check file selected or not
    if($("#file-upload").val()){
        fd.append('file-upload',form[0]);
        fd.append('uploadedFileName', $('input[type=file]')[0].files[0]);
        let searchParams = new URLSearchParams(window.location.search)
        if (searchParams.has('subdir'))
            fd.append('uploadedFilePath', searchParams.get('subdir'));

        clearFormInputs();
        apiSaveUploadedFile(fd);
    }else{
        clearFormInputs();
        displayMessage("Prosím, vyberte súbor.");
    }
});