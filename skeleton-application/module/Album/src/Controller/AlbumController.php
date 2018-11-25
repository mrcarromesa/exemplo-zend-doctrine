<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;



/*PAGINACAO*/
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
/*PAGINACAO*/

class AlbumController extends AbstractActionController
{

    protected $em;

    public function __construct($em = null) {
        $this->em = $em;
    }

    public function indexAction()
    {
        $em = $this->em->get('Doctrine\ORM\EntityManager');
        $query = $em->getRepository('Album\Album\Entity\Track')->findAll();
        
        /*implementar paginacao*/
        
        //$adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        
        $paginator = new Paginator(new ArrayAdapter($query));
        $page = $this->params()->fromQuery('page', 1);
        $paginator->setDefaultItemCountPerPage(1);        
        $paginator->setCurrentPageNumber($page);
        return new ViewModel([
            'posts' => $paginator,
            'page' => $page
            //'postManager' => $this->postManager
            //'tagCloud' => $tagCloud
        ]);
        
        
                       
        // Get popular tags.
        //$tagCloud = $this->postManager->getTagCloud();
        
        // Render the view template.
        /*implementar paginacao*/
        
        /*foreach($data as $key=>$row)
        {
            echo $row->getFkAlbum()->getArtista().' :: '.$row->getTitulo();
            echo '<br />';
        }*/
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