<?php
/*
 * This file is part of the BusinessCarouselBundle and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 * 
 * @license    GPL LICENSE Version 2.0
 * 
 */

namespace AlphaLemon\Block\BusinessCarouselBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AlphaLemon\Block\BusinessCarouselBundle\Core\Form\AlCarouselItemType;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarouselQuery;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarousel;
use AlphaLemon\AlphaLemonCmsBundle\Core\Model\AlBlockQuery;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerFactory;

/**
 * BusinessCarouselController
 *
 * @author AlphaLemon <info@alphalemon.com>
 */
class BusinessCarouselController extends Controller
{
    protected $item = null;
    
    public function listAction()
    {
        $request = $this->getRequest();
        $items = AlAppBusinessCarouselQuery::create()->findByBlockId($request->get('id'));
        
        return $this->render('BusinessCarouselBundle:Block:businesscarousel_editor.html.twig', array("items" => $items, "block_id" => $request->get('id')));
    }
    
    public function showItemAction()
    {
        $request = $this->getRequest();
        $form = $this->setUpForm($request->get('block_id'), $request->get('id'));        
        $formView = $this->renderForm($form);
        
        $formView = array('key' => 'editor', 'value' => $this->renderForm($form));
        return $this->buildJSonResponse(array($formView));
    }
    
    public function saveAction(Request $request)
    {
        try {
            $request = $this->getRequest();
            $params = $request->get('al_carousel_item');
            $form = $this->setUpForm($params["block_id"], $params["id"]);  
            $errors = $this->save($form);            
            
            // Resets the form after an add operation
            if(null == $params["id"] && count($errors) == 0) $form = $this->setUpForm($params["block_id"], 0); 
            
            $values = array();
            $values[] = array('key' => 'editor', 'value' => $this->renderForm($form, $errors)); 
            $values[] = array('key' => 'content', 'id' => $params["block_id"], 'value' => $this->getBlockContent($params["block_id"]));
            
            return $this->buildJSonResponse($values);
        }
        catch(\PropelException $e)
        {
            $response = new Response();
            $response->setStatusCode('404');
            return $this->render('AlphaLemonPageTreeBundle:Error:ajax_error.html.twig', array('message' => $e->getMessage()), $response);
        }
    }
    
    public function deleteAction()
    {
        try {
            $request = $this->getRequest();
            $this->setUpItem($request->get('blockId'), $request->get('id'));
            $this->item->delete();
            
            $items = AlAppBusinessCarouselQuery::create()->findByBlockId($request->get('blockId'));        
            $editor = $this->container->get('templating')->render('BusinessCarouselBundle:Block:businesscarousel_editor.html.twig', array("items" => $items, "block_id" => $request->get('blockId')));
            
            $values = array();
            $values[] = array('key' => 'editor', 'value' => $editor); 
            $values[] = array('key' => 'content', 'id' => $request->get('blockId'), 'value' => $this->getBlockContent($request->get('blockId')));
            
            return $this->buildJSonResponse($values);
        }
        catch(\PropelException $e)
        {
            $response = new Response();
            $response->setStatusCode('404');
            return $this->render('AlphaLemonPageTreeBundle:Error:ajax_error.html.twig', array('message' => $e->getMessage()), $response);
        }
    }
    
    protected function getBlockContent($id)
    {
        $alBlock = AlBlockQuery::create()->findPk($id);
        if(null === $alBlock) return "";
        $alBlockManager = AlBlockManagerFactory::createBlock($this->container, $alBlock);
        
        return $alBlockManager->getHtmlContentCMSMode();
    }

    protected function setUpItem($blockId, $id = null)
    {
        $request = $this->getRequest();
        if(null !== $id && $id != 0) {
            $this->item = AlAppBusinessCarouselQuery::create()->findPk($id); 
        }
        else {
            $this->item = new AlAppBusinessCarousel();
            $this->item->setBlockId($blockId);
        }
    }
    
    protected function setUpForm($blockId, $id = null)
    {
        $this->setUpItem($blockId, $id);
        
        return $this->createForm(new AlCarouselItemType(), $this->item);
    }
    
    protected function renderForm($form, $errors = null)
    {
        return $this->container->get('templating')->render('BusinessCarouselBundle:Block:carousel_item.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors,
        ));
    }
    
    protected function save($form)
    {
        $request = $this->getRequest();
        if ('POST' === $request->getMethod()) {
            try {
                $form->bindRequest($request);
                if ($form->isValid()) {
                    $this->item->save();                    
                }
                else {
                    return $form->getErrors();
                }
            }
            catch(\PropelException $ex)
            {
                throw $ex;
            }
        }
        
        return null;
    }
    
    protected function buildJSonResponse($values)
    {
        $response = new Response(json_encode($values));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

