<?php

namespace BlogApp\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{

    /**
     * List posts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $posts = array();

        return $this->render('BlogAppBlogBundle:Post:list.html.twig', array('posts' => $posts));
    }

}
