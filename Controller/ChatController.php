<?php

namespace Baml\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Baml\ChatBundle\Entity\Message;
use Baml\ChatBundle\Entity\Conversation;
use Baml\ChatBundle\Form\MessageType;
use Baml\ChatBundle\Form\ConversationType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
class ChatController extends Controller
{
	private function isAuthorizedConversation($user,$id){
		$conversation=$this->getDoctrine()
                     ->getManager()
                     ->getRepository('BamlChatBundle:Conversation')
                     ->getConversationWithParticipant($id,$user);
        if(is_null($conversation)){
	 		return $this->render('BamlChatBundle:Conversation:denied.html.twig');	       	
        }	
        return $conversation;	
	}
   /**
   * @Secure(roles="ROLE_USER")
   */
	public function listConversationAction()
	{
		$user = $this->getUser();
		$conversations=$user->getConversations();
		return $this->render('BamlChatBundle:Conversation:list.html.twig', array(
			'conversations'   => $conversations
		));			
	}
   /**
   * @Secure(roles="ROLE_USER")
   */
	public function seeConversationAction($id)
	{
		$user = $this->getUser();
		$conversation=$this->isAuthorizedConversation($user,$id);
		$message = new Message();
		$form = $this->createForm(new MessageType(), $message);
		return $this->render('BamlChatBundle:Conversation:show.html.twig', array(
			'form' => $form->createView(),
			'conversation'   => $conversation,
			'updateInterval' => 5000
		));		
	}
   /**
   * @Secure(roles="ROLE_USER")
   */
    public function newConversationAction()
    {
		$conversation = new Conversation();
		$form = $this->createForm(new ConversationType(), $conversation);
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$participants=$conversation->getParticipants();
				$authorIsIn=false;
				foreach($participants as $participant)
				{
					if($participant->getId()===$this->getUser()->getId())
					{
						$authorIsIn=true;
					}
				}
				if(!$authorIsIn)
				{
					$conversation->addParticipant($this->getUser());
				}
				$em->persist($conversation);
				$em->flush();			
				return $this->redirect($this->generateUrl('baml_chat_list_conversation'));
			}
		}

		return $this->render('BamlChatBundle:Conversation:new.html.twig', array(
		  'form' => $form->createView(),
		));		
    }
   /**
   * @Secure(roles="ROLE_USER")
   */
    public function newMessageAction($id)
    {
    	$user=$this->getUser();
    	$conversation=$this->isAuthorizedConversation($user,$id);
		$message = new Message();
		$form = $this->createForm(new MessageType(), $message);
		$request = $this->get('request');
		$conversation=$this->getDoctrine()
                     ->getManager()
                     ->getRepository('BamlChatBundle:Conversation')
                     ->find($id);
		$user=$this->getUser();
		if( $request->isXmlHttpRequest())
		{
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$message->setAuthor($user->getUsername());
				$em->persist($message);
				$em->flush();	
				$conversation->addMessage($message);
				
				$em->persist($message);
				$em->flush();	
				$response = new JsonResponse();
				/*$originalDate = $message->getSendDate();
				$newDate = date("d/m/Y-H:i", strtotime(to_string($originalDate)));*/
				$response->setData(array('text' => $message->getText(),'author'=>$message->getAuthor(),'date'=>$message->getSendDate()));
   
				/*return $this->container->get('templating')->renderResponse('BamlChatBundle:Conversation:listMessage.html.twig', array(
								'conversation'   => $conversation
					));			*/
					return $response;
			}
		}
		return $this->render('BamlChatBundle:Conversation:show.html.twig', array(
		  'form' => $form->createView(),
		  'conversation' => $conversation
		));				
	}
   /**
   * @Secure(roles="ROLE_USER")
   */
	public function listMessageAction($id)
	{
		$user=$this->getUser();
		$conversation=$this->isAuthorizedConversation($user,$id);
		/*$conversation=$this->getDoctrine()
                     ->getManager()
                     ->getRepository('BamlChatBundle:Conversation')
                     ->find($id);*/
		$messages=$conversation->getMessages();
		/*$response = new JsonResponse();
		$response->setData(array('messages'=>$messages));
		return $response;*/
		return $this->render('BamlChatBundle:Conversation:listMessage_ajax.html.twig', array(
			'conversation'   => $conversation
		));			
		

	}	
}
