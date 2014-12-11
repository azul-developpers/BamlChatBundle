$(document).ready(function(){
    $("#spinner").hide();
     $('.selectpicker').selectpicker();
    function sendMessage(e)
    {
        $("#spinner").show();
        var lien=$("#formMessage").attr("action");
        $.post(
           lien,
           $( "#formMessage" ).serialize(),
           postMessage
        );
        $("#baml_chatbundle_message_text").val('');
    }
    $("#chat_submit").click(function(e){
        e.preventDefault();
        sendMessage(e);
    });
    function newConversationForm(e){
        var lien_new_conversation=$("#lienNewConversation").attr("class");
        $.post(
            lien_new_conversation,
            function(data){
                $('#new_conversation_modal').html(data);
                $('#new_conversation_modal').show(1000);
            }
        );
    } 
    $("#bouton_add_conversation").click(function(e){
        e.preventDefault();
        newConversationForm(e);
    }); 
    function newConversationSend(){
        var lien=$("#formConversation").attr("action");
        $.post(
           lien,
           $( "#formConversation" ).serialize(),function(data){
                $('#new_conversation_modal').html(data);
           }
        );
        //$("#new_conversation_modal").hide(1000);
    }
    $("#new_conversation_submit").click(function(e){
        e.preventDefault();
        newConversationSend();
    });
    function updateChat()
    {
        var lienAjax=$("#lienAjax").attr('class');
        if(lienAjax.substr(lienAjax.length-1,lienAjax.length)!="0")
        $.post(lienAjax, function(data) {
        $("#content-table").html(data);
        });      
    }
    function postMessage(data)
    {
        if(data.date!=null){
            $('#listeMessage tr:last').after('<tr><td>'+data.author+'</td><td>'+data.text+'</td><td>'+data.date.date+'</td></tr>');        
        }
        else{
            $("#content-table").html(data);
        }
        $("#spinner").hide();
        
    }
    $('#baml_chatbundle_message_text').on('keydown', function(e) {
        if (e.which == 13 || e.keyCode == 13) 
        {
            e.preventDefault();
            sendMessage(e);
        
        }
    });
    $('#liste_conversation').on('change',function(e){
        var chaine =     $("#lienAjax").attr('class');
        var chaine2= $("#formMessage").attr("action");
        var longueur = chaine.length;
        var longueur2=chaine2.length;
        var sous_chaine=chaine.substr(0,longueur-1);
        var sous_chaine2=chaine2.substr(0,longueur2-1);
        $("#lienAjax").attr('class',sous_chaine+$('#liste_conversation').val());
        $("#formMessage").attr("action",sous_chaine2+$('#liste_conversation').val());
        updateChat();
    });
    setInterval(updateChat, 5000);

    
});
