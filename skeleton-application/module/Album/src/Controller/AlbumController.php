<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{

    protected $em;

    public function __construct($em = null) {
        $this->em = $em;
    }

    public function indexAction()
    {
        
        $em = $this->em->get('Doctrine\ORM\EntityManager');
        $data = $em->getRepository('Album\Album\Entity\Track')->findAll();
        foreach($data as $key=>$row)
        {
            echo $row->getFkAlbum()->getArtista().' :: '.$row->getTitulo();
            echo '<br />';
        }
        //return new ViewModel();
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}