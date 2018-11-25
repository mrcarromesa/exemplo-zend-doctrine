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

    public function getLimit() {
        $em = $this->em->get('Doctrine\ORM\EntityManager');
        $qb = $em->createQueryBuilder();
        $qb
            ->select('a')
            ->from('Album\Album\Entity\Track', 'a')
            //->where('u = :user')
            //->setParameter('user', 1)
            ->orderBy('a.titulo', 'ASC')
            ->setFirstResult(1)
            ->setMaxResults(1);

        
        foreach($qb->getQuery()->getResult() as $aa) {
            print_r($aa->getTitulo());
            //print_r($aa->getFkAlbum());
            /*if ((method_exists($aa,'getFkAlbum')) && (method_exists($aa->getFkAlbum(),'getArtista'))) {
                echo 'aqui';
                print_r($aa->getFkAlbum()->getArtista());
            }*/
            echo '<br>';
        }
    }

    public function deleteRegistro()
    {
        

        
        $em = $this->em->get('Doctrine\ORM\EntityManager');
        $qb = $em->createQueryBuilder();
        $qb->delete('Album\Album\Entity\Track', 's');
        $qb->where('s.id = :id');
        $qb->setParameter('id', 1);
        
        //... do some work
        $query = $qb->getQuery();
        $query->execute();
        

    }

    public function update()
    {
        $em = $this->em->get('Doctrine\ORM\EntityManager');
        
        
        $data = $em->getReference('Album\Album\Entity\Track', 2);
        $data->setTitulo('sdafasdf');

        $em->merge($data);
        $em->flush();

        //$em = $this->em->get('Doctrine\ORM\EntityManager');
        $idAlbum = $em->getRepository('Album\Album\Entity\Album')->findOneById(['id' => 1]);

        $track = new \Album\Album\Entity\Track;
        $track->setTitulo('insert');
        $track->setFkAlbum($idAlbum);
        $em->persist($track);
        $em->flush();
    }

    public function indexAction()
    {
        //======================LEFT JOIN COM DOCTRINE====================
        //$this->getLeftJoin();
        //======================LEFT JOIN COM DOCTRINE====================
        $this->update();
        $this->deleteRegistro();
        $this->getLimit();
        
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
        
        /*foreach($query as $key=>$row)
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