$(document).ready(function(){
    $("#spinner").hide();
    var lienAjax=$('#lienAjax').attr("class");
    var lien=$("#formMessage").attr("action");
    $("#_submit").click(function(e){
        $("#spinner").show();
        e.preventDefault();
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
        console.log('Update');
        if (this.timer)
            clearTimeout(this.timer);
        
        $.post(lienAjax, function(data) {
            $('#content').html(data);
        });
        this.timer = setTimeout(updateChat(), 5000);
    }
    function postMessage(data)
    {
        
        $('#listeMessage tr:last').after('<tr><td>'+data.author+'</td><td>'+data.text+'</td><td>'+data.date.date+'</td></tr>');
        
        
    }

    
});
