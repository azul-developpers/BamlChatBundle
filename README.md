<h1>BamlChatBundle</h1>

A Symfony AJAX Chat Bundle.

<h2>Installation</h2>

<ol>
  <li>Include the ChatController where you need your Chat : <br/>
   <code>{{ render(controller("BamlChatBundle:Chat:seeConversation",{ 'id': 1 })) }}</code></li>
   <li>Add JS File : <br/>   <code> {% javascripts '@BamlChatBundle/Resources/public/js/chat_ajax.js' %}
    <script type="text/javascript" src="{{ asset_url }}"></script> 
{% endjavascripts %}</code> </li>
   <li>Ads CSS File :<br/> <code> {% stylesheets
     '@BamlChatBundle/Resources/public/css/*' %}
     <link rel="stylesheet" href="{{ asset_url }}"/>
 {% endstylesheets %} </code></li>
</ol>
