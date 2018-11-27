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

    public function readCSV(){
        //print_r($this->basePath());
        
        /*ini_set('auto_detect_line_endings',TRUE);
        $handle = fopen('./data/teste.csv','r');
        while ( ($data = fgetcsv($handle) ) !== FALSE ) {
            print_r($data);
        }
        ini_set('auto_detect_line_endings',FALSE);*/
        
    }

    public function exportXlsAction()
    {
        set_time_limit( 0 );
        //$model = new Default_Model_SomeModel();
        //$data = $model->getData();
        $data = ['row' => ['col1'=>'teste1', 'col2'=> 'teste 3','col3'=>'teste4']];
        $filename =  "./data/excel-" . date( "m-d-Y" ) . ".xls";
        $realPath = realpath( $filename );
        if ( false === $realPath )
        {
            touch( $filename );
            chmod( $filename, 0777 );
        }
        $filename = realpath( $filename );
        $handle = fopen( $filename, "w" );
        $finalData = array();
        
        foreach ( $data AS $row )
        {
            $finalData[] = array(
                utf8_decode( $row["col1"] ), // For chars with accents.
                utf8_decode( $row["col2"] ),
                utf8_decode( $row["col3"] ),
            );
        }
        foreach ( $finalData AS $finalRow )
        {
            fputcsv( $handle, $finalRow, "\t" );
        }
        fclose( $handle );
        $view = new ViewModel([
            'message' => 'Hello world',
        ]);

        // Disable layouts; `MvcEvent` will use this View Model instead
        $view->setTerminal(true);

        /*$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();*/
        header( "Content-Type: application/vnd.ms-excel; charset=UTF-8" );
        header( "Content-Disposition: attachment; filename=otros-fondos.xls" );
        header( "Content-Transfer-Encoding: binary" );
        header( "Expires: 0" );
        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
        header( "Pragma: public" );
        header( "Content-Length: " . filesize( $filename ) );
        
        readfile( $filename ); exit();
        return $view;
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
        $this->readCSV();
        return $this->redirect()
            ->toRoute('album', 
                    array('action' => 'exportXls'
                    //,'id' => $message->getChat()->getId()
                    )
                    //,array('fragment' => 'm' . $message->getId())
        );
        //======================LEFT JOIN COM DOCTRINE====================
        //$this->getLeftJoin();
        //======================LEFT JOIN COM DOCTRINE====================
        //======================UPDATE E INSERT====================
        //$this->update();
        //======================UPDATE E INSERT====================
        //======================DELETE====================
        //$this->deleteRegistro();
        //======================DELETE====================
        //======================SELECT C/ LIMIT====================
        //$this->getLimit();
        //======================SELECT C/ LIMIT====================
        
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