<form id="uploadform" action="add.php" enctype="multipart/form-data" method="POST">
    <p>Имя<br><input type="text" name="NAME"></p>
    <p>Аватар<br><input type="file" id="sortpicture" name="FILE_AVA"></p>
    <input type="submit">
</form>
<button id="upload">Jnghfdbnm</button>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script>
    $('#upload').on('click', function() {
        var file_data = $('#sortpicture').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        alert(form_data);
        $.ajax({
            url: 'add.php', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response){
                alert(php_script_response); // display response from the PHP script, if any
            }
        });
    });
    $(document).ready(function (e) {
        $("#uploadform").on('submit', (function (e) {
            e.preventDefault();
            //$("#message").empty();
            //$('#loading').show();
            $.ajax({
                url: $("#uploadform").attr('action'), // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,        // To send DOMDocument or non processed data file it is set to false
                success: function (data)   // A function to be called if request succeeds
                {
                    alert(data);
                    /* $('#loading').hide();
                     $("#message").html(data);*/
                }
            });
        }));
    });
</script>