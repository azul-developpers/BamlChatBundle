<?php

namespace Baml\ChatBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ConversationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConversationRepository extends EntityRepository
{
	public function getConversationWithParticipant($id,$user){
		$conversation=$this->findOneById($id);
		if(is_null($conversation)){
			return null;
		}
		else{
			$listeConversation=$user->getConversations();
			if(is_null($listeConversation)){
				return null;
			}
			else{
				foreach($listeConversation as $conver){
					if($conver->getId()==$conversation->getId()){
						return $conversation;
					}	
				}

			}
		}

		return null;
	}
}
