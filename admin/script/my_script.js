$("#sub").click(function(){
	$("#result").html("<p>���������� ������...</p>");

//$.post($("#myForm").attr("action"),$("#myForm :input").serializeArray(),function(info){ $("#result").html(info); });
    var formData = new FormData($('#myForm')[0]);
    $.post($("#myForm").attr("action"),formData,function(info){
        $("#result").html(info);
        console.log(info);
    });

    clearInput();
});

$("#myForm").submit(function(){
return false;
});

function clearInput(){
	$("#myForm :input").each(function() {
        $(this).val('');
    });
}