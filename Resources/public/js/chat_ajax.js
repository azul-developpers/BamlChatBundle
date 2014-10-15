$(document).ready(function(){
    $("#spinner").hide();
    $("#_submit").click(function(e){
        e.preventDefault();
        $("#spinner").show();
        var lien=$("#formMessage").attr("action");

        $.post(
           lien,
           $( "#formMessage" ).serialize(),
           postMessage
        );
        $("#baml_chatbundle_message_text").val('');
        $("#spinner").hide();
    }); 

    function updateChat()
    {
        var lienAjax=$("#lienAjax").attr('class');
        var donnee=$("td[style]").last().html();
        $.post(lienAjax, function(data) {
            $("#content-table").html(data);
        });
        
    }
    function postMessage(data)
    {
        
        $('#listeMessage tr:last').after('<tr><td>'+data.author+'</td><td>'+data.text+'</td><td>'+data.date.date+'</td></tr>');
        
        
    }
    
    setInterval(updateChat, 5000);

    
});
