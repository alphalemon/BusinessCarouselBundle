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

namespace AlphaLemon\Block\BusinessCarouselBundle\Core\Listener; 

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use AlphaLemon\AlphaLemonCmsBundle\Core\Event\Actions\Block\BlockEditorRenderingEvent;
use AlphaLemon\Block\BusinessCarouselBundle\Core\Block\AlBlockManagerBusinessCarousel;
use AlphaLemon\Block\BusinessCarouselBundle\Model\AlAppBusinessCarouselQuery;

/**
 * Manipulates the block's editor response when the editor has been rendered 
 *
 * @author alphalemon <webmaster@alphalemon.com>
 */
class RenderingEditorListener 
{
    public function onBlockEditorRendering(BlockEditorRenderingEvent $event)
    {
        try
        {
            $alBlockManager = $event->getAlBlockManager();  
            if($alBlockManager instanceof AlBlockManagerBusinessCarousel) {
                $items = AlAppBusinessCarouselQuery::create()->findByBlockId($alBlockManager->get()->getId());
                
                $template = sprintf('%sBundle:Block:%s_editor.html.twig', $alBlockManager->get()->getClassName(), strtolower($alBlockManager->get()->getClassName()));
                $editor = $event->getContainer()->get('templating')->render($template, array("items" => $items, "block_id" => $alBlockManager->get()->getId()));
                $event->setEditor($editor);
            }
        }
        catch(\Exception $ex)
        {
            throw $ex;
        }
    }
}
