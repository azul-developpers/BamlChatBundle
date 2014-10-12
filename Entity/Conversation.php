<?php

namespace Baml\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 *
 * @ORM\Table("baml_conversation")
 * @ORM\Entity(repositoryClass="Baml\ChatBundle\Entity\ConversationRepository")
 */
class Conversation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */    
    private $title;
	/**
	* @ORM\OneToMany(targetEntity="Message", mappedBy="conversation")
	*/
	private $messages;
    /**
     * @ORM\ManyToMany(targetEntity="\Baml\UserBundle\Entity\User", inversedBy="conversations")
     * @ORM\JoinTable(name="participants")
     */	
	private $participants;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add messages
     *
     * @param \Baml\ChatBundle\Entity\Message $messages
     * @return Conversation
     */
    public function addMessage(\Baml\ChatBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;
		$messages->setConversation($this);
        return $this;
    }

    /**
     * Remove messages
     *
     * @param \Baml\ChatBundle\Entity\Message $messages
     */
    public function removeMessage(\Baml\ChatBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add participants
     *
     * @param \Baml\UserBundle\Entity\User $participants
     * @return Conversation
     */
    public function addParticipant(\Baml\UserBundle\Entity\User $participants)
    {
        $this->participants[] = $participants;
		$participants->addConversation($this);
        return $this;
    }

    /**
     * Remove participants
     *
     * @param \Baml\UserBundle\Entity\User $participants
     */
    public function removeParticipant(\Baml\UserBundle\Entity\User $participants)
    {
        $this->participants->removeElement($participants);
        $participants->removeConversation($this);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Conversation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
}
