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

    public function getLeftJoin()
    {
        $em = $this->em->get('Doctrine\ORM\EntityManager');
        $qb = $em->createQueryBuilder();
        $qb
            ->select('a', 'u')
            ->from('Album\Album\Entity\Track', 'a')
            ->leftJoin(
                'Album\Album\Entity\Album',
                'u',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'a.fkAlbum = u.id'
            )
            ->where('u = :user')
            ->setParameter('user', 1)
            ->orderBy('a.titulo', 'DESC');

        
        foreach($qb->getQuery()->getResult() as $aa) {
            //print_r($aa->getArtista());
            //print_r($aa->getFkAlbum());
            if ((method_exists($aa,'getFkAlbum')) && (method_exists($aa->getFkAlbum(),'getArtista'))) {
                echo 'aqui';
                print_r($aa->getFkAlbum()->getArtista());
            }
            echo '<br>';
        }
    }

    public function indexAction()
    {
        //======================LEFT JOIN COM DOCTRINE====================
        //$this->getLeftJoin();
        //======================LEFT JOIN COM DOCTRINE====================
        
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