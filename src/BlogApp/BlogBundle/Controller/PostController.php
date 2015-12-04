<?php

namespace BlogApp\BlogBundle\Controller;

use BlogApp\BlogBundle\Entity\Comment;
use BlogApp\BlogBundle\Entity\Post;
use BlogApp\BlogBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostController
 */
class PostController extends Controller
{

    /**
     * List posts
     *
     * @param int $page - page number
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($page)
    {
        $posts = $this->getDoctrine()
                        ->getRepository('BlogApp\BlogBundle\Entity\Post')
                        ->getPostsByPage($page);

        $data = array(
            'posts' => $posts,
            'pages' => ceil(count($posts) / Post::POSTS_PER_PAGE),
            'page' => $page
        );

        return $this->render('BlogAppBlogBundle:Post:list.html.twig', $data);
    }

    /**
     * View a post
     *
     * @param Request $request
     * @param int $id - post identifier
     * @param int $page - page number
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $id, $page)
    {
        $post = $this->getDoctrine()
                        ->getManager()
                        ->find('BlogApp\BlogBundle\Entity\Post', $id);

        $comment = new Comment();

        $form = $this->createForm(new CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setApproved(true);
            $comment->setCreatedDate(new \DateTime());
            $comment->setPost($post);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            //Empty the form after submission
            $comment = new Comment();
            $form = $this->createForm(new CommentType(), $comment);
        }

        $data = array(
            'post' => $post,
            'form' => $form->createView(),
            'page' => $page
        );

        return $this->render('BlogAppBlogBundle:Post:view.html.twig', $data);
    }

}
