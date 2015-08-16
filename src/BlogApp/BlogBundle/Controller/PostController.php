<?php

namespace BlogApp\BlogBundle\Controller;

use BlogApp\BlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PostController
 */
class PostController extends Controller
{

    /**
     * List posts
     *
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($page)
    {
        $posts = $this->getDoctrine()
                        ->getRepository('BlogApp\BlogBundle\Entity\Post')
                        ->getPostsByPage($page);

        $data = array(
            'posts' => $posts,
            'pages' => ceil(count($posts) / Post::POSTS_PER_PAGE)
        );

        return $this->render('BlogAppBlogBundle:Post:list.html.twig', $data);
    }

    /**
     * View a post
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id)
    {
        $post = $this->getDoctrine()
                        ->getManager()
                        ->find('BlogApp\BlogBundle\Entity\Post', $id);

        return $this->render('BlogAppBlogBundle:Post:view.html.twig', array('post' => $post));
    }

}
