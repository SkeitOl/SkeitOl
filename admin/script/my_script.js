$("#sub").click(function(){
	$("#result").html("<p>���������� ������...</p>");
$.post($("#myForm").attr("action"),$("#myForm :input").serializeArray(),function(info){ $("#result").html(info); });
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